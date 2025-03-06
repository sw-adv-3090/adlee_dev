<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data['booklets'] = $request->user()->booklets->count();
        $data['coupons'] = $request->user()->coupons->count();
        $data['activated'] = $request->user()->coupons()->whereNotNull('activated_at')->count();
        $data['paid_out'] = $request->user()->coupons()->whereNotNull('payout_at')->count();
        $data['spend'] = $request->user()->transactions()->sum('paid_amount');
        $data['transactions'] = $request->user()->transactions()->select(['paid_amount', 'receiver_id', 'created_at'])->with(['receiver:id,name,profile_photo_url'])->latest()->take(6)->get();
        $data['tasks'] = Task::with(['coupon:id,uuid,title,language,payout_on,amount', 'template:id,preview', 'company'])->whereBelongsTo($request->user())->whereNotNull(['template_id', 'printed_at'])->whereHas('coupon', fn($q) => $q->whereNull('payout_at'))->latest()->get();

        // dd($data['tasks']->first()->coupon->payout_on);
        return view('sponsor.dashboard', compact('data'));
    }
}
