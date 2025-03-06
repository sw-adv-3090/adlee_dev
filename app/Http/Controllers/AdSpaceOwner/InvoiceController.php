<?php

namespace App\Http\Controllers\AdSpaceOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Transaction;

class InvoiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function invoice(Transaction $transaction)
    {
        return view('ad-space-owner.invoice', compact('transaction'));
    }

    /**
     * Handle the incoming request.
     */
    public function view(Transaction $transaction)
    {
        $transaction->load(['sender', 'receiver', 'sponsor', 'company']);
        $type = 'ad-space-owner';

        return view('emails.invoice', compact('transaction', 'type'));
    }

    public function download(Transaction $transaction)
    {
        $transaction->load(['sender', 'receiver', 'sponsor', 'company']);

        $pdf = Pdf::loadView("emails.invoice", ['transaction' => $transaction, 'type' => 'ad-space-owner'])->setPaper('legal', 'landscape');

        return $pdf->download("invoice-$transaction->number.pdf");

        // Mail::to($transaction->sender)->send(new SendInvoice($transaction,'sponsor'));

        // return back()->with('success', 'Invoice has been sent successfully.');
    }
}
