@extends('layouts.guest')
@section('title', 'Entrar')
@section('content')
<section class="card p-4">
    <h1 class="h3 mb-4">Entrar</h1>
    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <div class="mb-3">
    <label for="email" class="form-label">E-mail</label>
    <input id="email" name="email" type="email" autocomplete="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" maxlength="255" required>
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div><div class="mb-3">
    <label for="password" class="form-label">Senha</label>
    <input id="password" name="password" type="password" autocomplete="current-password" class="form-control @error('password') is-invalid @enderror" required>
    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
    <div class="text-center mt-4"><a href="{{ route('register') }}">Criar uma conta</a></div>
</section>
@endsection
