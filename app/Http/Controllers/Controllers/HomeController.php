<?php

namespace App\Http\Controllers;

use App\Services\TapfiliateService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, TapfiliateService $service)
    {
        if ($request->has('ref') && $request->get('ref') !== null) {
            $response = $service->clicks($request->get('ref'));
            if (isset($response['id'])) {
                $clickId = $response['id'];
                $request->session()->put('clickId', $clickId);
            }

        }

        return view('website.index');
        // return to_route('login');
    }
}
