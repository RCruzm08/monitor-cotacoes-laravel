@extends('layouts.app')
@section('title', 'Meus alertas')
@section('content')
<div class="d-flex flex-wrap justify-content-between gap-3 mb-4"><div><h1 class="h2">Meus alertas</h1><p class="text-body-secondary mb-0">Acompanhe os preços alvo e os alertas atingidos.</p></div><div><a href="{{ route('alerts.create') }}" class="btn btn-primary">Novo alerta</a></div></div>
<section class="card p-4"><div class="table-responsive"><table class="table"><thead><tr><th scope="col">Ativo</th><th scope="col">Condição</th><th scope="col">Preço alvo</th><th scope="col">Status</th><th scope="col">Disparado em</th><th scope="col">Ações</th></tr></thead><tbody>
@forelse ($alerts as $alert)
    <tr><td><a href="{{ route('assets.show', $alert->asset) }}">{{ $alert->asset->code }}</a><div class="small text-body-secondary">{{ $alert->asset->name }}</div></td><td>{{ $alert->condition === 'above' ? 'Maior ou igual (≥)' : 'Menor ou igual (≤)' }}</td><td class="price text-nowrap">R$ {{ number_format((float) $alert->target_price, 4, ',', '.') }}</td><td><span class="badge {{ $alert->is_triggered ? 'text-bg-success' : 'text-bg-info' }}">{{ $alert->is_triggered ? 'Disparado' : 'Ativo' }}</span></td><td class="text-nowrap">{{ $alert->triggered_at?->format('d/m/Y H:i') ?? '—' }}</td><td><div class="d-flex gap-2"><a href="{{ route('alerts.edit', $alert) }}" class="btn btn-outline-light btn-sm">Editar</a><form method="POST" action="{{ route('alerts.destroy', $alert) }}" onsubmit="return confirm('Excluir este alerta?');">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm" type="submit" aria-label="Excluir alerta de {{ $alert->asset->code }}">Excluir</button></form></div></td></tr>
@empty
    <tr><td colspan="6" class="empty-state">Você ainda não criou alertas. Clique em “Novo alerta” para começar.</td></tr>
@endforelse
</tbody></table></div></section>
@endsection
