<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Notifications\DeferPayoutNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ExtendDeadlineController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Coupon $coupon)
    {
        $coupon->loadSum('transactions', 'amount');

        return view('sponsor.coupons.extend-payout', compact('coupon'));
    }

    /**
     * Sending payment to BBO.
     */
    public function extend(Request $request, Coupon $coupon)
    {
        $request->validate(['days' => ['required', 'numeric', 'min:1']]);
        $coupon->load(['redeem:id,name,email']);
        $deadline = Carbon::parse($coupon->payout_on)->addDays((int) $request->days);

        $coupon->update(['payout_on' => $deadline]);

        Notification::send($coupon->redeem, new DeferPayoutNotification($coupon->redeem->name, $coupon->number, $deadline->format('F j, Y')));

        return to_route('sponsors.coupons.index')->with('status', 'Coupon deadline successfully extended!');
    }
}
