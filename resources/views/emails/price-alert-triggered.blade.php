<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Alerta de cotação atingido</title></head>
<body style="font-family:Arial,sans-serif;color:#1e293b;background:#f1f5f9;padding:24px;">
<main style="max-width:600px;margin:auto;background:#ffffff;padding:32px;border-radius:12px;">
    <h1 style="color:#0e7490;font-size:24px;">Seu alerta foi atingido!</h1>
    <p>Olá, {{ $alert->user->name }}.</p>
    <p>O ativo <strong>{{ $alert->asset->name }} ({{ $alert->asset->code }})</strong> atingiu a condição configurada.</p>
    <p><strong>Preço alvo:</strong> R$ {{ number_format((float) $alert->target_price, 4, ',', '.') }}<br>
    <strong>Condição:</strong> {{ $alert->condition === 'above' ? 'Maior ou igual ao alvo' : 'Menor ou igual ao alvo' }}<br>
    <strong>Disparado em:</strong> {{ $alert->triggered_at?->format('d/m/Y H:i:s') ?? '—' }}</p>
    <p><a href="{{ route('alerts.index') }}" style="color:#0e7490;">Acessar meus alertas</a></p>
    <p style="color:#64748b;font-size:12px;">MarketWatch Analytics</p>
</main>
</body>
</html>
