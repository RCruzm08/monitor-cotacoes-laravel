@foreach (['success' => 'success', 'error' => 'danger', 'warning' => 'warning'] as $key => $style)
    @if (session($key))
        <div class="alert alert-{{ $style }}" role="alert">{{ session($key) }}</div>
    @endif
@endforeach
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <strong>Confira os dados informados.</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
