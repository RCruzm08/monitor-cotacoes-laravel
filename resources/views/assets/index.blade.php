@extends('layouts.app')
@section('title', 'Dashboard de cotações')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div><h1 class="h2">Dashboard de cotações</h1><p class="text-body-secondary mb-0">Moedas e criptomoedas monitoradas em reais.</p></div>
    <form method="POST" action="{{ route('assets.sync') }}">
        @csrf
        <button class="btn btn-primary" type="submit" @disabled(!$canSync)>Sincronizar cotações</button>
    </form>
</div>
@unless ($canSync)
    <div class="alert alert-info" role="status">A sincronização ficará disponível quando o comando de atualização de cotações estiver configurado.</div>
@endunless
<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card p-4 h-100"><span class="text-body-secondary">Maior variação</span>
        @if ($topGainer)<strong class="fs-4 mt-2">{{ $topGainer->code }}</strong><span class="{{ $topGainer->variation_24h >= 0 ? 'text-up' : 'text-down' }}">{{ number_format((float) $topGainer->variation_24h, 2, ',', '.') }}%</span>@else<span class="mt-2">Sem dados</span>@endif
    </div></div>
    <div class="col-md-4"><div class="card p-4 h-100"><span class="text-body-secondary">Menor variação</span>
        @if ($topLoser)<strong class="fs-4 mt-2">{{ $topLoser->code }}</strong><span class="{{ $topLoser->variation_24h >= 0 ? 'text-up' : 'text-down' }}">{{ number_format((float) $topLoser->variation_24h, 2, ',', '.') }}%</span>@else<span class="mt-2">Sem dados</span>@endif
    </div></div>
    <div class="col-md-4"><div class="card p-4 h-100"><span class="text-body-secondary">Meus alertas ativos</span><strong class="fs-4 mt-2">{{ $activeAlertsCount }}</strong><a href="{{ route('alerts.index') }}">Gerenciar alertas</a></div></div>
</div>
<section class="card p-4 mb-4" aria-label="Filtros de ativos">
    <form method="GET" action="{{ route('assets.index') }}" class="row g-3 align-items-end">
        <div class="col-md-6"><label class="form-label" for="search">Pesquisar ativo</label><input class="form-control" id="search" name="search" value="{{ request('search') }}" maxlength="100" placeholder="Nome ou código, como Bitcoin ou USD"></div>
        <div class="col-md-3"><label class="form-label" for="type">Tipo</label><select class="form-select" id="type" name="type"><option value="">Todos</option><option value="fiat" @selected(request('type') === 'fiat')>Moedas</option><option value="crypto" @selected(request('type') === 'crypto')>Criptomoedas</option></select></div>
        <div class="col-md-3 d-flex gap-2"><button type="submit" class="btn btn-primary">Filtrar</button><a class="btn btn-outline-light" href="{{ route('assets.index') }}">Limpar</a></div>
    </form>
</section>
<div class="row g-3">
@forelse ($assets as $asset)
    <div class="col-md-6 col-xl-4"><article class="card h-100 p-4">
        <div class="d-flex justify-content-between gap-3"><div><h2 class="h5 mb-1">{{ $asset->name }}</h2><span class="text-body-secondary">{{ $asset->code }} / BRL</span></div><span class="badge text-bg-secondary align-self-start">{{ $asset->type === 'crypto' ? 'Cripto' : 'Moeda' }}</span></div>
        @if ($asset->current_price > 0)
            <strong class="price fs-3 my-3">R$ {{ number_format((float) $asset->current_price, 4, ',', '.') }}</strong>
            <span class="{{ $asset->variation_24h >= 0 ? 'text-up' : 'text-down' }}">{{ $asset->variation_24h > 0 ? '+' : '' }}{{ number_format((float) $asset->variation_24h, 2, ',', '.') }}% em 24h</span>
            <div class="small text-body-secondary mt-3">Máxima: R$ {{ number_format((float) $asset->high_price, 4, ',', '.') }}<br>Mínima: R$ {{ number_format((float) $asset->low_price, 4, ',', '.') }}</div>
        @else
            <p class="text-body-secondary my-4">Aguardando a primeira cotação.</p>
        @endif
        <div class="d-flex flex-wrap gap-2 mt-auto pt-4"><a href="{{ route('assets.show', $asset) }}" class="btn btn-outline-light btn-sm">Ver histórico</a><a href="{{ route('alerts.create', ['asset_id' => $asset->id]) }}" class="btn btn-primary btn-sm">Criar alerta</a></div>
    </article></div>
@empty
    <div class="col-12"><div class="card empty-state">Nenhum ativo encontrado. Ajuste os filtros ou cadastre os ativos iniciais.</div></div>
@endforelse
</div>
@endsection
