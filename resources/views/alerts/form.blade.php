<div class="mb-3">
    <label for="asset_id" class="form-label">Ativo</label>
    <select id="asset_id" name="asset_id" class="form-select @error('asset_id') is-invalid @enderror" required>
        <option value="">Selecione um ativo</option>
        @foreach ($assets as $asset)
            <option value="{{ $asset->id }}" @selected((string) old('asset_id', $alert->asset_id ?? $selectedAssetId ?? '') === (string) $asset->id)>{{ $asset->code }} — {{ $asset->name }}</option>
        @endforeach
    </select>
    @error('asset_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="target_price" class="form-label">Preço alvo em reais</label>
    <input id="target_price" name="target_price" type="number" inputmode="decimal" min="0.0001" step="0.0001" value="{{ old('target_price', $alert->target_price ?? '') }}" class="form-control @error('target_price') is-invalid @enderror" aria-describedby="price-help" required>
    <div id="price-help" class="form-text text-body-secondary">Informe um valor positivo, com até quatro casas decimais.</div>
    @error('target_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-4">
    <label for="condition" class="form-label">Avisar quando o preço for</label>
    <select id="condition" name="condition" class="form-select @error('condition') is-invalid @enderror" required>
        <option value="above" @selected(old('condition', $alert->condition ?? 'above') === 'above')>Maior ou igual ao preço alvo (≥)</option>
        <option value="below" @selected(old('condition', $alert->condition ?? 'above') === 'below')>Menor ou igual ao preço alvo (≤)</option>
    </select>
    @error('condition')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<p class="small text-body-secondary">O aviso será enviado para {{ auth()->user()->email }} quando uma sincronização atingir a condição.</p>
<div class="d-flex flex-wrap gap-2"><button type="submit" class="btn btn-primary" @disabled($assets->isEmpty())>{{ $submitLabel }}</button><a href="{{ route('alerts.index') }}" class="btn btn-outline-light">Cancelar</a></div>
