@extends('layouts.app')
@section('title', $asset->name)
@section('content')
<a href="{{ route('assets.index') }}" class="d-inline-block mb-3">← Voltar às cotações</a>
<div class="d-flex flex-wrap justify-content-between gap-3 mb-4"><div><h1 class="h2">{{ $asset->name }} <span class="text-body-secondary">{{ $asset->code }}</span></h1><p class="text-body-secondary mb-0">{{ $asset->type === 'crypto' ? 'Criptomoeda' : 'Moeda' }} · Cotação em BRL</p></div><div><a class="btn btn-primary" href="{{ route('alerts.create', ['asset_id' => $asset->id]) }}">Criar alerta para este ativo</a></div></div>
<section class="card p-4 mb-4">
    <div class="row g-4">
        <div class="col-md-4"><span class="text-body-secondary">Cotação atual</span><div class="price fs-3 fw-bold">{{ $asset->current_price > 0 ? 'R$ '.number_format((float) $asset->current_price, 4, ',', '.') : 'Aguardando cotação' }}</div></div>
        <div class="col-md-4"><span class="text-body-secondary">Máxima / mínima</span><div class="price mt-2">R$ {{ number_format((float) $asset->high_price, 4, ',', '.') }} / R$ {{ number_format((float) $asset->low_price, 4, ',', '.') }}</div></div>
        <div class="col-md-4"><span class="text-body-secondary">Variação em 24h</span><div class="fs-4 {{ $asset->variation_24h >= 0 ? 'text-up' : 'text-down' }}">{{ number_format((float) $asset->variation_24h, 2, ',', '.') }}%</div></div>
    </div>
    <p class="text-body-secondary small mb-0 mt-3">Última coleta: {{ $lastFetchedAt?->format('d/m/Y H:i:s') ?? 'Nenhuma coleta realizada' }}</p>
</section>
<section class="card p-4"><h2 class="h4 mb-3">Histórico de cotações</h2>
    <div class="table-responsive"><table class="table"><thead><tr><th scope="col">Data da coleta</th><th scope="col">Preço</th><th scope="col">Máxima</th><th scope="col">Mínima</th></tr></thead><tbody>
    @forelse ($histories as $history)
        <tr><td>{{ $history->fetched_at?->format('d/m/Y H:i:s') ?? '—' }}</td><td class="price">R$ {{ number_format((float) $history->price, 4, ',', '.') }}</td><td class="price">R$ {{ number_format((float) $history->high_price, 4, ',', '.') }}</td><td class="price">R$ {{ number_format((float) $history->low_price, 4, ',', '.') }}</td></tr>
    @empty
        <tr><td colspan="4" class="empty-state">Ainda não há histórico de cotações para este ativo.</td></tr>
    @endforelse
    </tbody></table></div>
    {{ $histories->links('pagination::bootstrap-5') }}
</section>
@endsection
