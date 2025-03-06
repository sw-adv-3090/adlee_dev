<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShipEngineWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $payload = $request->all();

        Log::info("Shipengine webhook request received.");
        Log::debug(json_encode($payload));

        // Return a 204 No Content response to indicate that the webhook has been processed successfully
        return response()->noContent();
    }
}
