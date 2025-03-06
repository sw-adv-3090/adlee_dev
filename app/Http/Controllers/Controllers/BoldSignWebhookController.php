<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BoldSignWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $payload = $request->all();
        $data = $payload['data'];
        // Process the data and perform actions based on the payload
        if ($data['object'] === 'document' && $data['status'] === 'Completed') {
            Task::where('document_id', $data['documentId'])->update(['signed_at' => now()]);
        }

        // Log::debug($data);

        // Return a 204 No Content response to indicate that the webhook has been processed successfully
        return response()->noContent();
    }
}
