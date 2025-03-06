<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ShipEngineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ShipmentCarrierController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(ShipEngineService $service)
    {
        $carriers = cache()->remember('carriers', 3600, fn() => $service->carriers());
        // dd($carriers);

        return view('admin.settings.ship-carrier', compact('carriers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // update settings
        foreach ($request->except('_token') as $key => $value) {
            Setting::updateOrCreate([
                'key' => $key
            ], [
                'value' => $value
            ]);
        }

        // clear the cache so that the new settings apply
        Artisan::call('cache:clear');

        // redirect to index page with success message
        return back()->with('success', 'Shipment Carrier information updated successfully.');
    }
}
