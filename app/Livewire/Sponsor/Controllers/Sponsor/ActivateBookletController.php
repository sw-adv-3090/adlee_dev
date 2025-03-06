<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Booklet;
use App\Models\Sponsor;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivateBookletController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function index(Booklet $booklet)
    {
        $booklet->load(['coupons']);
        $data['total'] = $booklet->coupons->count();
        $data['activated'] = $booklet->coupons->whereNotNull('activated_at')->count();
        $data['notActivated'] = $booklet->coupons->whereNull('activated_at')->count();
        $data['isCommemoration'] = request()->user()->sponsor->is_commemoration;

        return view('sponsor.booklets.activate', compact('data', 'booklet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function activate(Request $request, Booklet $booklet)
    {
        $booklet->load(['coupons']);
        foreach ($booklet->coupons as $coupon) {
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
        }


        return redirect()->route('sponsors.booklets.index')->withSuccess('Booklet activated successfully!');

    }
}
