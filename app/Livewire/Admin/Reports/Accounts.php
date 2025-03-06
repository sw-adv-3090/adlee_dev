<?php

namespace App\Livewire\Admin\Reports;

use App\Enums\UserRole;
use App\Models\BookletPrint;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
class Accounts extends Component
{
    use WithPagination;

    public int $perPage = 100;
    public array $filters = [];
    public array $filter = [];
    public array $plans = [];
    public $value; // filter type
    public $operator; // filter operator equal, lessa than, greater than, between
    public $search; // if operator is not between then search query
    public $start, $end; // if operator is between then search query between two value
    public $payment_type = "all"; // filter payemtns based on type
    public $transaction_type = "all"; // filter trasnaction based on type, credit-card or ach
    public $paid_by = "all"; // filter by commission paid by
    public $user_type = "all"; // filter users based on type
    public $cancel_type = "all"; // filter users based on type account cancel
    public $plan_type_join = "all"; // filter users based on plan they have joined
    public $plan_type_cancel = "all"; // filter users based on plan they have cancel

    public function mount()
    {
        $this->filters = accounts_filters();
        $this->filter = $this->filters[0];
        $this->value = $this->filter['value'];
        $this->operator = $this->filter['options'][0]['value'];
        $this->plans[] = ['key' => 'all', 'value' => 'All'];
        foreach (Plan::select(['name', 'stripe_product_id'])->get() as $plan) {
            $this->plans[] = [
                'key' => $plan->stripe_product_id,
                'value' => $plan->name,
            ];
        }
    }

    public function render()
    {
        // payments
        $paymentQuery = Payment::query()
            ->with(['user', 'plan'])
            ->when($this->operator === "equal" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->whereDate('created_at', $this->search))
            ->when($this->operator === "before" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->where('created_at', '<', $this->search))
            ->when($this->operator === "after" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->where('created_at', '>', $this->search))
            ->when($this->operator === "between" && !empty($this->start) && !empty($this->end) && $this->value === "created_at", fn($query) => $query->whereBetween('created_at', [$this->start, $this->end]))
            ->when($this->payment_type === "Sponsor Basic" || $this->payment_type === "Sponsor Premier", fn($query) => $query->whereHas('plan', fn($q) => $q->whereLike(['name'], $this->payment_type)))
            ->when($this->payment_type === "Sponsor All", fn($query) => $query->whereNotNull('sponsor_id')->whereNotNull('stripe_price'))
            ->when($this->payment_type === "Ad Space Owner", fn($query) => $query->whereNotNull('ad_space_owner_id')->whereNotNull('stripe_price'))
            ->when($this->payment_type === "Booklet Print", fn($query) => $query->whereType('booklet'))
        ;

        $data['paymentAmount'] = $paymentQuery->clone()->sum('amount') / 100;
        $data['payments'] = $paymentQuery->clone()->latest()->paginate($this->perPage, '*', 'payments');

        // transactions
        $transactionQuery = Transaction::query()
            ->with(['sender:id,email', 'receiver:id,email', 'sponsor:id,company_name,company_logo', 'company', 'coupon:id,number'])
            ->when($this->operator === "equal" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->whereDate('created_at', $this->search))
            ->when($this->operator === "before" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->where('created_at', '<', $this->search))
            ->when($this->operator === "after" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->where('created_at', '>', $this->search))
            ->when($this->operator === "between" && !empty($this->start) && !empty($this->end) && $this->value === "created_at", fn($query) => $query->whereBetween('created_at', [$this->start, $this->end]))
            ->when($this->transaction_type === "ach" || $this->transaction_type === "credit-card", fn($query) => $query->whereType($this->transaction_type))
            ->when($this->paid_by === "Sponsor", fn($query) => $query->where('commission_paid', true))
            ->when($this->paid_by === "Ad Space Owner", fn($query) => $query->where('commission_paid', false))
        ;

        $data['trnasactionAmount'] = $transactionQuery->clone()->sum('service_fee');
        $data['transactions'] = $transactionQuery->clone()->latest()->paginate($this->perPage, '*', 'transactions');

        // accounts joinded
        $accountJoinedQuery = User::query()
            ->whereHas('subscriptions', fn($q) => $q->active())
            ->when($this->operator === "equal" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->whereDate('created_at', $this->search))
            ->when($this->operator === "before" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->where('created_at', '<', $this->search))
            ->when($this->operator === "after" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->where('created_at', '>', $this->search))
            ->when($this->operator === "between" && !empty($this->start) && !empty($this->end) && $this->value === "created_at", fn($query) => $query->whereBetween('created_at', [$this->start, $this->end]))
            ->when($this->user_type === "Sponsor", fn($query) => $query->where('role_id', UserRole::Sponsor->value))
            ->when($this->user_type === "Ad Space Owner", fn($query) => $query->where('role_id', UserRole::AdSpaceOwner->value))
            ->when($this->plan_type_join !== "all", fn($query) => $query->whereHas('userPlan', fn($q) => $q->where('stripe_product_id', $this->plan_type_join)))
        ;

        $data['sponsorJoinedCount'] = $accountJoinedQuery->clone()->where('role_id', UserRole::Sponsor->value)->count();
        $data['bboJoinedCount'] = $accountJoinedQuery->clone()->where('role_id', UserRole::AdSpaceOwner->value)->count();
        $data['accountsJoined'] = $accountJoinedQuery->clone()->latest()->paginate($this->perPage, "*", 'users');


        // accounts canceled
        $accountCancelledQuery = User::query()
            ->whereDoesntHave('subscriptions', fn($q) => $q->active())
            ->when($this->operator === "equal" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->whereDate('created_at', $this->search))
            ->when($this->operator === "before" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->where('created_at', '<', $this->search))
            ->when($this->operator === "after" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->where('created_at', '>', $this->search))
            ->when($this->operator === "between" && !empty($this->start) && !empty($this->end) && $this->value === "created_at", fn($query) => $query->whereBetween('created_at', [$this->start, $this->end]))
            ->when($this->cancel_type === "Sponsor", fn($query) => $query->where('role_id', UserRole::Sponsor->value))
            ->when($this->cancel_type === "Ad Space Owner", fn($query) => $query->where('role_id', UserRole::AdSpaceOwner->value))
            ->when($this->plan_type_cancel !== "all", fn($query) => $query->whereHas('userPlan', fn($q) => $q->where('stripe_product_id', $this->plan_type_cancel)))
        ;

        $data['sponsorCancelledCount'] = $accountCancelledQuery->clone()->where('role_id', UserRole::Sponsor->value)->count();
        $data['bboCancelledCount'] = $accountCancelledQuery->clone()->where('role_id', UserRole::AdSpaceOwner->value)->count();
        $data['accountsCanceled'] = $accountCancelledQuery->clone()->latest()->paginate($this->perPage, "*", 'cancelled');

        // free booklets
        $data['freeBooklets'] = BookletPrint::query()
            ->with([
                'booklet' => function ($query) {
                    $query->withCount('coupons');
                }
            ])
            ->where('type', 'free')
            ->when($this->operator === "equal" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->whereDate('created_at', $this->search))
            ->when($this->operator === "before" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->where('created_at', '<', $this->search))
            ->when($this->operator === "after" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->where('created_at', '>', $this->search))
            ->when($this->operator === "between" && !empty($this->start) && !empty($this->end) && $this->value === "created_at", fn($query) => $query->whereBetween('created_at', [$this->start, $this->end]))
            ->latest()
            ->get();

        $data['paidBooklets'] = BookletPrint::query()
            ->with([
                'booklet' => function ($query) {
                    $query->withCount('coupons');
                }
            ])
            ->where('type', 'paid')
            ->when($this->operator === "equal" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->whereDate('created_at', $this->search))
            ->when($this->operator === "before" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->where('created_at', '<', $this->search))
            ->when($this->operator === "after" && !empty($this->search) && $this->value === "created_at", fn($query) => $query->where('created_at', '>', $this->search))
            ->when($this->operator === "between" && !empty($this->start) && !empty($this->end) && $this->value === "created_at", fn($query) => $query->whereBetween('created_at', [$this->start, $this->end]))
            ->latest()
            ->get();

        $data['coupons'] = [];

        return view('livewire.admin.reports.accounts', compact('data'));
    }

    public function updatedValue()
    {
        $this->filter = collect($this->filters)->filter(function ($item) {
            return $item['value'] === $this->value;
        })->first();
    }

    // public function updatedSearch()
    // {
    //     dd($this->search);
    // }

    // public function updatedOperator()
    // {
    //     dd($this->operator);
    // }
}
