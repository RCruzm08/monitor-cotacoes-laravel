<?php

namespace App\Console\Commands;

use App\Services\AlertService;
use App\Services\QuoteService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdateQuotesCommand extends Command
{
    protected $signature = 'quotes:update';

    protected $description = 'Atualiza cotações, registra histórico e verifica alertas de preço';

    public function handle(QuoteService $quotes, AlertService $alerts): int
    {
        $lock = Cache::lock('quotes:update', 120);

        if (!$lock->get()) {
            $this->warn('Já existe uma sincronização em andamento.');

            return self::FAILURE;
        }

        try {
            $updated = $quotes->updateQuotes();
            $triggered = $alerts->checkAlerts();
            $this->info("Cotações atualizadas: {$updated}. Alertas disparados: {$triggered}.");

            return self::SUCCESS;
        } catch (Throwable $exception) {
            Log::error('Falha ao atualizar cotações.', [
                'exception' => $exception::class,
                'error' => $exception->getMessage(),
            ]);
            $this->error('Não foi possível sincronizar as cotações. Consulte storage/logs/laravel.log.');

            return self::FAILURE;
        } finally {
            $lock->release();
        }
    }
}
