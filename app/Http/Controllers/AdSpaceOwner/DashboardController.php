<?php

namespace App\Http\Controllers\AdSpaceOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;


class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // dd($request->user()->tasks);
        $tickets = $request->user()->tickets();
        $data['tickets'] = $tickets->clone()->count();
        $data['paid_out'] = $tickets->clone()->whereNotNull('payout_at')->count();
        $data['partial_paid_out'] = $tickets->clone()->whereNull('payout_at')->has('transactions')->count();
        $data['tickets_needs_action'] = $request->user()->tasks()->whereNull('printed_at')->count();
        $data['earned'] = $request->user()->bboTransactions()->sum('receiver_amount');
        $data['transactions'] = $request->user()->bboTransactions()->select(['receiver_amount', 'sender_id', 'created_at'])->with(['sender:id,name,profile_photo_url'])->latest()->take(6)->get();
        $data['tasks'] = Task::with(['coupon:id,uuid,title,language,payout_on,amount', 'template:id,preview', 'sponsor'])->where('assign_to', auth()->id())->whereNotNull(['template_id', 'printed_at'])->whereHas('coupon', fn($q) => $q->whereNull('payout_at'))->latest()->get();

        return view('ad-space-owner.dashboard', compact('data'));
    }
}
