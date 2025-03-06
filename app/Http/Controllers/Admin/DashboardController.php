<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data['tasks'] = Task::with(['coupon:id,title,language,payout_on', 'template:id,preview', 'company'])->whereNotNull(['template_id', 'printed_at'])->whereHas('coupon', fn($q) => $q->whereNull('payout_at'))->latest()->take(6)->get();
        $data['topSponsors'] = User::query()
            ->select(['id', 'email', 'name'])
            ->with(['sponsor:id,user_id,company_name,company_logo'])
            ->withCount(['coupons', 'sponsorTasks' => fn($q) => $q->whereNotNull('printed_at')])
            ->withSum('transactions', 'amount')
            ->where('role_id', UserRole::Sponsor->value)
            ->whereHas('coupons')
            ->whereHas('transactions')
            ->orderBy('transactions_sum_amount', 'desc')
            ->orderBy('coupons_count', 'desc')
            ->take(10)
            ->get();

        // dd($data['topSponsors']);

        return view('admin.dashboard', compact('data'));
    }
}
