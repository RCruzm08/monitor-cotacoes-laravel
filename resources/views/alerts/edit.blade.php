@extends('layouts.app')
@section('title', 'Editar alerta')
@section('content')
<a href="{{ route('alerts.index') }}" class="d-inline-block mb-3">← Voltar aos alertas</a>
<div class="row"><div class="col-lg-7"><section class="card p-4">
    <h1 class="h3 mb-4">Editar alerta</h1>
    <div class="alert alert-info">Ao salvar, o alerta será reativado e a data de disparo será limpa.</div>
    @if ($assets->isEmpty())<div class="alert alert-warning">Nenhum ativo disponível para criar alertas.</div>@endif
    <form method="POST" action="{{ route('alerts.update', $alert) }}">
        @csrf
        @method('PUT')
        @include('alerts.form', ['submitLabel' => 'Salvar alterações'])
    </form>
</section></div></div>
@endsection
