<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ShipFromSettingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        return view('admin.settings.ship-from');
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
        return back()->with('success', 'Ship from address updated successfully.');
    }
}
