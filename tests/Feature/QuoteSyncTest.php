<?php

namespace Tests\Feature;

use App\Mail\PriceAlertTriggered;
use App\Models\Asset;
use App\Models\User;
use Database\Seeders\AssetSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class QuoteSyncTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['services.quotes.url' => 'https://economia.awesomeapi.com.br/json/last/USD-BRL,EUR-BRL,GBP-BRL,BTC-BRL,ETH-BRL']);
        $this->seed(AssetSeeder::class);
        Mail::fake();
        Http::preventStrayRequests();
    }

    private function payload(): array
    {
        $data = [];

        foreach (Asset::all() as $asset) {
            $data[$asset->code.'BRL'] = [
                'code' => $asset->code,
                'codein' => 'BRL',
                'bid' => '5.2500',
                'high' => '5.5000',
                'low' => '5.0000',
                'pctChange' => '1.25',
            ];
        }

        return $data;
    }

    public function test_sync_stores_quotes_history_and_triggers_alert_only_once(): void
    {
        Http::fake(['economia.awesomeapi.com.br/*' => Http::response($this->payload())]);
        $user = User::factory()->create();
        $asset = Asset::where('code', 'USD')->firstOrFail();
        $alert = $user->alerts()->create([
            'asset_id' => $asset->id, 'target_price' => '5.0000', 'condition' => 'above',
        ]);

        $this->artisan('quotes:update')->assertSuccessful();
        $this->assertSame('5.2500', $asset->fresh()->current_price);
        $this->assertDatabaseCount('price_histories', 5);
        $this->assertTrue($alert->fresh()->is_triggered);
        $this->assertNotNull($alert->fresh()->triggered_at);
        Mail::assertSent(PriceAlertTriggered::class, fn ($mail) => $mail->hasTo($user->email));

        $this->artisan('quotes:update')->assertSuccessful();
        $this->assertDatabaseCount('price_histories', 10);
        Mail::assertSentCount(1);
    }

    public function test_missing_quote_does_not_write_a_partial_batch(): void
    {
        $payload = $this->payload();
        unset($payload['ETHBRL']);
        Http::fake(['economia.awesomeapi.com.br/*' => Http::response($payload)]);

        $this->artisan('quotes:update')->assertFailed();
        $this->assertDatabaseCount('price_histories', 0);
        $this->assertSame('0.0000', Asset::where('code', 'USD')->firstOrFail()->current_price);
        Mail::assertNothingSent();
    }

    public function test_http_failure_preserves_previous_prices(): void
    {
        $asset = Asset::where('code', 'USD')->firstOrFail();
        $asset->update(['current_price' => '4.0000']);
        Http::fake(['economia.awesomeapi.com.br/*' => Http::response([], 503)]);

        $this->artisan('quotes:update')->assertFailed();
        $this->assertSame('4.0000', $asset->fresh()->current_price);
        $this->assertDatabaseCount('price_histories', 0);
        Mail::assertNothingSent();
    }

    public function test_dashboard_enables_sync_and_guests_cannot_execute_it(): void
    {
        $this->post(route('assets.sync'))->assertRedirect(route('login'));
        $this->actingAs(User::factory()->create())->get(route('assets.index'))
            ->assertOk()->assertDontSee('A sincronização ficará disponível');
        Http::assertNothingSent();
    }
}
