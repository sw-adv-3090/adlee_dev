<?php

namespace App\Http\Controllers\AdSpaceOwner;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class RedeemCouponController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        if (!is_null($coupon->redeemed_by)) {
            abort_if($coupon->redeemed_by !== auth()->user()->email, 403);
        }
        abort_if(!is_null($coupon->redeemed_at), 403, 'Coupon already redeemed.');
        $coupon->load(['sponsor:id,company_name']);

        return view('ad-space-owner.coupons.redeem', compact('coupon'));
    }

    /**
     * Select template for the specified coupon.
     */
    public function templates(Request $request, Coupon $coupon)
    {
        if (!is_null($coupon->redeemed_by)) {
            abort_if($coupon->redeemed_by !== auth()->user()->email, 403);
        }
        abort_if(!is_null($coupon->redeemed_at), 403, 'Coupon already redeemed.');
        $coupon->load(['user:id,email', 'sponsor:id,company_name', 'adSpaceOwner', 'task']);

        // $coupon->update(['redeemed_by' => auth()->user()->email]);
        // $coupon->task->update(['assign_to' => auth()->id()]);

        return view('ad-space-owner.coupons.template', compact('coupon'));
    }


    /**
     * Redeem the specified coupon.
     */
    public function redeem(Request $request, Coupon $coupon)
    {
        dd($request->all());
    }

}
