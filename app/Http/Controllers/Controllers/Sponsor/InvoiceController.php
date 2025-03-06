<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendInvoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function invoice(Transaction $transaction)
    {
        return view('sponsor.invoice', compact('transaction'));
    }

    /**
     * Handle the incoming request.
     */
    public function view(Transaction $transaction)
    {
        $transaction->load(['sender', 'receiver', 'sponsor', 'company']);
        $type = 'sponsor';

        return view('emails.invoice', compact('transaction', 'type'));
    }

    public function download(Transaction $transaction)
    {
        $transaction->load(['sender', 'receiver', 'sponsor', 'company']);

        $pdf = Pdf::loadView("emails.invoice", ['transaction' => $transaction, 'type' => 'sponsor'])->setPaper('legal', 'landscape');

        return $pdf->download("invoice-$transaction->number.pdf");

        // Mail::to($transaction->sender)->send(new SendInvoice($transaction,'sponsor'));

        // return back()->with('success', 'Invoice has been sent successfully.');
    }
}
