<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class DeactivateCouponController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        abort_if(!is_null($coupon->redeemed_at), 403);

        $coupon->load(['redeem:id,name,email', 'booklet']);

        return view('sponsor.coupons.deactivate', compact('coupon'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function deactivate(Request $request, Coupon $coupon)
    {
        DB::transaction(function () use ($request, $coupon) {
            // deleting coupon task
            $coupon->task?->delete();

            // deactivating coupon
            $coupon->update(['activated_at' => null]);
        });

        return redirect()->route('sponsors.coupons.index')->withSuccess('Coupon deactivated successfully!');

    }
}
