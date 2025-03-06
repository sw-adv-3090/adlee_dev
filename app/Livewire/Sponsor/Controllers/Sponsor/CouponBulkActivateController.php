<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Sponsor;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponBulkActivateController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if (!$request->has('coupons') && !is_array($request->get('coupons'))) {
            abort(404);
        }

        $payloads = $request->get('coupons');
        $coupons = [];
        foreach ($payloads as $id) {
            if (Coupon::where('uuid', $id)->whereNull('activated_at')->exists()) {
                $coupons[] = $id;
            }
        }
        $totalAmount = Coupon::whereIn('uuid', $coupons)->sum('amount') / 100;
        $sponsor = request()->user()->sponsor;
        $is_commemoration = $sponsor->is_commemoration;
        $isBookletCoupons = Coupon::where('uuid', $id)->whereNotNull('booklet_id')->exists() ? true : false;
        $bookletId = Coupon::where('uuid', $id)->whereNotNull('booklet_id')->first()?->booklet_id;

        return view('sponsor.coupons.bulk-activate', compact('coupons', 'sponsor', 'is_commemoration', 'totalAmount', 'isBookletCoupons', 'bookletId'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function activate(Request $request)
    {
        $request->validate([
            'coupons' => ['required', 'string']
        ]);
        $coupons = json_decode($request->get('coupons'));

        foreach ($coupons as $id) {
            $coupon = Coupon::where('uuid', $id)->first();

            // make sure the coupon exists and is not activated yet
            if ($coupon && is_null($coupon->activated_at)) {
                // activating coupon
                $coupon->update(['activated_at' => now()]);

                $userId = auth()->id();
                $sponsor = Sponsor::where('user_id', $userId)->first();

                // creating new task
                Task::create([
                    'user_id' => $userId,
                    'sponsor_id' => sponsorId(),
                    'coupon_id' => $coupon->id,
                    'assign_to' => $coupon->redeem?->id,
                    'is_commemoration' => $sponsor->is_commemoration,
                    'language' => $request->language,
                    'purpose' => $request->purpose,
                    'english_name' => $request->english_name,
                    'hebrew_name' => $request->hebrew_name,
                    'english_title' => $request->english_title,
                    'hebrew_title' => $request->hebrew_title,
                ]);
            }

        }


        return redirect()->route('sponsors.coupons.index')->withSuccess('Coupons activated successfully!');

    }

}
