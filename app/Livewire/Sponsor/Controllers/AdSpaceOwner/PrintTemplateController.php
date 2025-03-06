<?php

namespace App\Http\Controllers\AdSpaceOwner;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\DataService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintTemplateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Coupon $coupon)
    {
        $coupon->load(['task']);
        return view('ad-space-owner.coupons.print', compact('coupon'));
    }
    /**
     * Handle the print request.
     */
    public function print(Request $request, Coupon $coupon, DataService $service)
    {
        $coupon->load(['task', 'sponsor', 'user']);

        if (is_null($coupon->task->document_id) || is_null($coupon->task->signed_at)) {
            return back()->with('error', 'Please provide e-signature consent first to download the template.');
        }

        // if user is not signed his consent through e-signature
        if (is_null($coupon->task->signed_at)) {
            $success = sign_task($coupon);

            if (!$success) {
                return back()->with('error', 'Please provide e-signature consent first to download the template.');
            }
        }

        // update database
        $coupon->task->update(['printed_at' => now(), 'status' => 'printed']);
        $coupon->update(['payout_on' => now()->addDays($coupon->payout_deadline)]);

        // Generate pdf file
        $template = $coupon->task->template;
        $language = $template?->language ?? 'english';
        $name = $language . "_name";
        $commemoration = $coupon->task->$name;
        $pdf = Pdf::loadView($template->view, $service->template($coupon, $commemoration, "print"))->setPaper('legal', 'landscape');

        return $pdf->download($coupon->number . '.pdf');

    }
}
