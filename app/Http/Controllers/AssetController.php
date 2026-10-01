<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\PriceHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AssetController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'type' => ['nullable', 'in:fiat,crypto'],
        ]);
        $assets = Asset::query()
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(fn ($query) => $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%"));
            })
            ->when($filters['type'] ?? null, fn ($query, $type) => $query->where('type', $type))
            ->orderBy('name')->get();
        $topGainer = Asset::where('current_price', '>', 0)->orderByDesc('variation_24h')->first();
        $topLoser = Asset::where('current_price', '>', 0)->orderBy('variation_24h')->first();
        $activeAlertsCount = $request->user()->alerts()->where('is_triggered', false)->count();
        $canSync = array_key_exists('quotes:update', Artisan::all());
        $lastFetchedAt = PriceHistory::max('fetched_at');

        return view('assets.index', compact('assets', 'topGainer', 'topLoser', 'activeAlertsCount', 'canSync', 'lastFetchedAt'));
    }

    public function show(Asset $asset): View
    {
        $histories = $asset->priceHistories()->orderByDesc('fetched_at')->orderByDesc('id')->paginate(10);
        $lastFetchedAt = $asset->priceHistories()->orderByDesc('fetched_at')->first()?->fetched_at;
        $chartData = $asset->priceHistories()
            ->orderByDesc('fetched_at')->orderByDesc('id')->limit(180)->get()
            ->reverse()->values()
            ->map(fn ($history) => [
                'price' => (float) $history->price,
                'time' => $history->fetched_at->toIso8601String(),
            ])->all();

        return view('assets.show', compact('asset', 'histories', 'lastFetchedAt', 'chartData'));
    }

    public function sync(): RedirectResponse
    {
        if (!array_key_exists('quotes:update', Artisan::all())) {
            return to_route('assets.index')->with('error', 'A sincronização ainda não está configurada neste projeto.');
        }
        try {
            $exitCode = Artisan::call('quotes:update');
        } catch (\Throwable $exception) {
            Log::error('Falha na sincronização manual.', ['error' => $exception->getMessage()]);

            return to_route('assets.index')->with('error', 'Não foi possível atualizar as cotações. Tente novamente mais tarde.');
        }

        return to_route('assets.index')->with($exitCode === 0 ? 'success' : 'error',
            $exitCode === 0 ? 'Cotações atualizadas com sucesso.' : 'Não foi possível atualizar as cotações.');
    }
}
