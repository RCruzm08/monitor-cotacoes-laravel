<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>@include('layouts.head')</head>
<body>
<header class="mw-nav border-bottom">
    <nav class="container d-flex flex-wrap align-items-center gap-3 py-3" aria-label="Navegação principal">
        <a class="brand me-auto" href="{{ route('assets.index') }}">MarketWatch <span class="text-body-secondary fw-normal">Analytics</span></a>
        <a class="nav-link px-3 py-2 {{ request()->routeIs('assets.*') ? 'active' : '' }}" href="{{ route('assets.index') }}">Cotações</a>
        <a class="nav-link px-3 py-2 {{ request()->routeIs('alerts.*') ? 'active' : '' }}" href="{{ route('alerts.index') }}">Meus alertas</a>
        <span class="text-body-secondary text-break">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm">Sair</button>
        </form>
    </nav>
</header>
<main class="container py-4 py-md-5">
    @include('partials.messages')
    @yield('content')
</main>
<footer class="container pb-4 text-body-secondary small">MarketWatch Analytics · Valores em reais (BRL).</footer>
</body>
</html>
