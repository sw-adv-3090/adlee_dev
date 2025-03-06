<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class PreviewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $transaction = Transaction::with(['sender', 'receiver', 'sponsor', 'company'])->first();

        return view('emails.invoice', compact('transaction'));
    }
}
