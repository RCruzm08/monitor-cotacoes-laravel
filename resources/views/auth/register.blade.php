@extends('layouts.guest')
@section('title', 'Criar conta')
@section('content')
<section class="card p-4">
    <h1 class="h3 mb-4">Criar conta</h1>
    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <div class="mb-3">
    <label for="name" class="form-label">Nome</label>
    <input id="name" name="name" type="text" autocomplete="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" minlength="3" maxlength="100" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div><div class="mb-3">
    <label for="email" class="form-label">E-mail</label>
    <input id="email" name="email" type="email" autocomplete="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" maxlength="255" required>
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div><div class="mb-3">
    <label for="password" class="form-label">Senha</label>
    <input id="password" name="password" type="password" autocomplete="new-password" class="form-control @error('password') is-invalid @enderror" minlength="8" required>
    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div><div class="mb-3">
    <label for="password_confirmation" class="form-label">Confirmar senha</label>
    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="form-control @error('password_confirmation') is-invalid @enderror" minlength="8" required>
    @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
        <button type="submit" class="btn btn-primary w-100">Criar conta</button>
    </form>
    <div class="text-center mt-4"><a href="{{ route('login') }}">Já tenho uma conta</a></div>
</section>
@endsection
