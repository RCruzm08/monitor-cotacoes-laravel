@extends('layouts.app')
@section('title', 'Criar alerta')
@section('content')
<a href="{{ route('alerts.index') }}" class="d-inline-block mb-3">← Voltar aos alertas</a>
<div class="row"><div class="col-lg-7"><section class="card p-4">
    <h1 class="h3 mb-4">Criar alerta</h1>
    
    @if ($assets->isEmpty())<div class="alert alert-warning">Nenhum ativo disponível para criar alertas.</div>@endif
    <form method="POST" action="{{ route('alerts.store') }}">
        @csrf
        
        @include('alerts.form', ['submitLabel' => 'Criar alerta'])
    </form>
</section></div></div>
@endsection
