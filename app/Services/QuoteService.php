<?php

namespace App\Services;

use App\Models\Asset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class QuoteService
{
    public function updateQuotes(): int
    {
        $url = config('services.quotes.url');

        if (!is_string($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new RuntimeException('Configure uma QUOTES_API_URL válida no .env.');
        }

        $assets = Asset::orderBy('id')->get();

        if ($assets->isEmpty()) {
            throw new RuntimeException('Nenhum ativo cadastrado. Execute php artisan db:seed --class=AssetSeeder.');
        }

        $request = Http::acceptJson()->connectTimeout(5)->timeout(15);

        if ($key = config('services.quotes.key')) {
            $request = $request->withHeaders(['x-api-key' => $key]);
        }

        $response = $request->get($url);
        $response->throw();
        $data = $response->json();

        if (!is_array($data)) {
            throw new RuntimeException('A API retornou dados em formato inválido.');
        }

        // Validate the complete batch before changing prices or writing history.
        $quotes = [];

        foreach ($assets as $asset) {
            $quote = $data[$asset->code.'BRL'] ?? null;

            if (!is_array($quote) || ($quote['code'] ?? null) !== $asset->code
                || ($quote['codein'] ?? null) !== 'BRL') {
                throw new RuntimeException("Cotação em BRL ausente ou inválida para {$asset->code}.");
            }

            $validator = Validator::make($quote, [
                'bid' => ['required', 'numeric', 'gt:0', 'lt:100000000'],
                'high' => ['required', 'numeric', 'gt:0', 'lt:100000000'],
                'low' => ['required', 'numeric', 'gt:0', 'lt:100000000'],
                'pctChange' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            ]);

            if ($validator->fails()) {
                throw new RuntimeException("Valores de cotação inválidos para {$asset->code}.");
            }

            $quotes[$asset->id] = $quote;
        }

        return DB::transaction(function () use ($assets, $quotes) {
            $fetchedAt = now();

            foreach ($assets as $asset) {
                $quote = $quotes[$asset->id];
                $asset->update([
                    'current_price' => $quote['bid'],
                    'high_price' => $quote['high'],
                    'low_price' => $quote['low'],
                    'variation_24h' => $quote['pctChange'],
                ]);
                $asset->priceHistories()->create([
                    'price' => $quote['bid'],
                    'high_price' => $quote['high'],
                    'low_price' => $quote['low'],
                    'fetched_at' => $fetchedAt,
                ]);
            }

            return $assets->count();
        });
    }
}
