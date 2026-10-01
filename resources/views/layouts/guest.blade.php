<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>@include('layouts.head')</head>
<body>
<main class="container py-5">
    <div class="text-center mb-4"><span class="brand fs-4">MarketWatch Analytics</span><p class="text-body-secondary mt-2">Acompanhe cotações e configure seus alertas.</p></div>
    <div class="row justify-content-center"><div class="col-12 col-md-7 col-lg-5">
        @include('partials.messages')
        @yield('content')
    </div></div>
</main>
</body>
</html>
