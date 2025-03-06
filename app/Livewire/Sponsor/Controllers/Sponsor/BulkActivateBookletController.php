<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Booklet;
use App\Models\Sponsor;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BulkActivateBookletController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->has('booklets') && !is_array($request->get('booklets'))) {
            abort(404);
        }

        $payloads = $request->get('booklets');
        $data['booklets'] = count($payloads);
        $data['bookletIds'] = [];
        $data['totalCoupons'] = 0;
        $data['activated'] = 0;
        $data['notActivated'] = 0;
        $data['isCommemoration'] = request()->user()->sponsor->is_commemoration;

        foreach ($payloads as $bookletId) {
            $booklet = Booklet::with(['coupons'])->find($bookletId);
            if ($booklet) {
                $data['bookletIds'][] = $booklet->id;
                $data['totalCoupons'] += $booklet->coupons->count();
                $data['activated'] += $booklet->coupons->whereNotNull('activated_at')->count();
                $data['notActivated'] += $booklet->coupons->whereNull('activated_at')->count();
            }
        }

        return view('sponsor.booklets.bulk-activate', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function activate(Request $request)
    {
        $bookletIds = json_decode($request->booklets, true);
        $booklets = Booklet::with(['coupons'])->find($bookletIds);
        foreach ($booklets as $booklet) {
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
        }


        return redirect()->route('sponsors.booklets.index')->withSuccess('Booklets activated successfully!');

    }
}
