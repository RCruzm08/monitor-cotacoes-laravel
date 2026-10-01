<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlertRequest;
use App\Models\Asset;
use App\Models\PriceAlert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlertController extends Controller
{
    public function index(Request $request): View
    {
        $alerts = $request->user()->alerts()->with('asset')->latest()->get();

        return view('alerts.index', compact('alerts'));
    }

    public function create(Request $request): View
    {
        $assets = Asset::orderBy('name')->get();
        $selectedAssetId = $request->query('asset_id');

        return view('alerts.create', compact('assets', 'selectedAssetId'));
    }

    public function store(AlertRequest $request): RedirectResponse
    {
        $request->user()->alerts()->create($request->validated());

        return to_route('alerts.index')->with('success', 'Alerta criado com sucesso.');
    }

    public function edit(Request $request, PriceAlert $alert): View
    {
        abort_unless((int) $alert->user_id === (int) $request->user()->id, 403);
        $assets = Asset::orderBy('name')->get();

        return view('alerts.edit', compact('alert', 'assets'));
    }

    public function update(AlertRequest $request, PriceAlert $alert): RedirectResponse
    {
        abort_unless((int) $alert->user_id === (int) $request->user()->id, 403);
        $alert->update([...$request->validated(), 'is_triggered' => false, 'triggered_at' => null]);

        return to_route('alerts.index')->with('success', 'Alerta atualizado com sucesso.');
    }

    public function destroy(Request $request, PriceAlert $alert): RedirectResponse
    {
        abort_unless((int) $alert->user_id === (int) $request->user()->id, 403);
        $alert->delete();

        return to_route('alerts.index')->with('success', 'Alerta excluído com sucesso.');
    }
}
