<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Sponsor;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivateCouponController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        abort_if(!is_null($coupon->activated_at), 403);

        $coupon->load(['redeem:id,name,email', 'booklet']);
        $is_commemoration = request()->user()->sponsor->is_commemoration;

        return view('sponsor.coupons.activate', compact('coupon', 'is_commemoration'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function activate(Request $request, Coupon $coupon)
    {
        if (is_null($coupon->activated_at)) {
            DB::transaction(function () use ($request, $coupon) {
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
            });
        }

        return redirect()->route('sponsors.coupons.index')->withSuccess('Coupon activated successfully!');

    }

}
