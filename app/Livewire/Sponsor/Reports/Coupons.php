<?php

namespace App\Livewire\Sponsor\Reports;

use App\Models\Coupon;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class Coupons extends Component
{
    use WithPagination;

    public int $perPage = 8;
    public array $filters = [];
    public array $filter = [];
    public $value; // filter type
    public $operator; // filter operator equal, lessa than, greater than, between
    public $search; // if operator is not between then search query
    public $start, $end; // if operator is between then search query between two value
    public $columns = []; // all columns
    public $show_columns = []; // all columns to be shown on table
    public string $sponsor = ""; // filter coupon based on sponsor
    public string $type = "both"; // filter coupon based on type
    public string $language = "all"; // filter coupon based on language
    public string $title = ""; // filter coupon based on title
    public string $coupon_number = ""; // filter coupon based on coupon_number
    public string $booklet_number = ""; // filter booklet based on booklet_number
    public string $coupon_booklet_cost = "both"; // filter booklet based on coupon_booklet_cost
    public string $original_amount = ""; // filter coupon based on original_amount
    public string $original_amount_operator = "=";
    public string $amount_paid = ""; // filter coupon based on amount_paid
    public string $amount_paid_operator = "=";
    public string $coupon_balance = ""; // filter coupon based on coupon_balance
    public string $coupon_balance_operator = "=";
    public string $status = "all"; // filter coupon based on status
    public string $created_at = ""; // filter coupon based on created_at
    public string $created_at_operator = "=";
    public string $activated_at = ""; // filter coupon based on activated_at
    public string $activated_at_operator = "=";
    public string $redeemed_at = ""; // filter coupon based on redeemed_at
    public string $redeemed_at_operator = "=";
    public string $signed_at = ""; // filter coupon based on signed_at
    public string $signed_at_operator = "=";
    public string $printed_at = ""; // filter coupon based on printed_at
    public string $printed_at_operator = "=";
    public string $payout_on = ""; // filter coupon based on payout_on
    public string $payout_on_operator = "=";
    public string $payout_at = ""; // filter coupon based on payout_at
    public string $payout_at_operator = "=";
    public string $redeemed = "all"; // filter coupon based on redeemed
    public string $payment_applied = "all"; // filter coupon based on payment_applied
    public string $due_by = "all"; // filter coupon based on due_by
    public string $due_by_operator = "=";
    public string $transaction_method = "both"; // filter coupon based on transaction_method
    public string $fee_payer = "either"; // filter coupon based on fee_payer
    public string $transaction_fee = ""; // filter coupon based on transaction_fee
    public string $transaction_fee_operator = "=";
    public string $transaction_fee_cost = ""; // filter coupon based on transaction_fee_cost
    public string $transaction_fee_cost_operator = "=";
    public string $credit_card_fee = ""; // filter coupon based on credit_card_fee
    public string $credit_card_fee_operator = "=";
    public string $credit_card_fee_cost = ""; // filter coupon based on credit_card_fee_cost
    public string $credit_card_fee_cost_operator = "=";
    public string $ach_fee = ""; // filter coupon based on ach_fee
    public string $ach_fee_operator = "=";
    public string $ach_fee_cost = ""; // filter coupon based on ach_fee_cost
    public string $ach_fee_cost_operator = "=";
    public array $checkedCoupons = [];

    public function mount()
    {
        $this->filters = accounts_filters();
        $this->filter = $this->filters[0];
        $this->value = $this->filter['value'];
        $this->operator = $this->filter['options'][0]['value'];
        $this->columns = sponsors_coupon_report_columns();
        $this->show_columns = ["type", "language", "title", "booklet_number", "coupon_number"];
        // $this->checkedCoupons = session('selectedCoupons', []);
    }

    public function render()
    {
        return view('livewire.coupon-report', [
            'coupons' => Coupon::query()
                ->whereBelongsTo(auth()->user())
                ->with(['booklet.print', 'task:id,coupon_id,printed_at,signed_at,template_id', 'transactions', 'sponsor', 'user:id,name,email', 'redeem:id,name,email'])
                ->withSum('transactions', 'paid_amount')
                ->withSum('transactions', 'amount')
                ->selectRaw('(amount / 100) - IFNULL((SELECT SUM(transactions.amount) FROM transactions WHERE transactions.coupon_id = coupons.id), 0) as remaining_amount')
                // filter coupon by type of coupons
                ->when($this->type === "virtual", fn($q) => $q->whereNull('booklet_id'))
                ->when($this->type === "physical", fn($q) => $q->whereNotNull('booklet_id'))
                ->when($this->language !== "all", fn($q) => $q->where('language', $this->language))
                // filter coupon by title of coupons
                ->when($this->title, fn($q) => $q->whereLike(['title'], $this->title))
                // filter coupon by number of coupons
                ->when($this->coupon_number, fn($q) => $q->whereLike(['number'], $this->coupon_number))
                // filter coupon by booklet number of coupons
                ->when($this->booklet_number, fn($q) => $q->whereLike(['booklet.number'], $this->booklet_number))
                // filter coupon by booklet cost
                ->when($this->coupon_booklet_cost !== "both", fn($q) => $q->whereHas('booklet', fn($query) => $query->whereLike(['print.type'], $this->coupon_booklet_cost)))
                // filter coupon by coupons original amount
                ->when($this->original_amount, fn($q) => $q->where('amount', $this->original_amount_operator, $this->original_amount * 100))
                // filter coupon by total coupon paid amount inclusing service fee and trasnaction fee
                ->when($this->amount_paid, fn($q) => $q->having('transactions_sum_paid_amount', $this->amount_paid_operator, $this->amount_paid))
                // filter coupon by coupons remaining balance to be paid
                ->when($this->coupon_balance, fn($q) => $q->having('remaining_amount', $this->coupon_balance_operator, $this->coupon_balance))
                // filter coupon by coupons status
                ->when($this->status === "invited_to_redeem", fn($q) => $q->whereNotNull('redeemed_by')->whereNull('redeemed_at'))
                ->when($this->status === "activated", fn($q) => $q->whereNotNull('activated_at'))
                ->when($this->status === "redeemed", fn($q) => $q->whereNotNull('redeemed_at'))
                ->when($this->status === "paid_out", fn($q) => $q->whereNotNull('payout_at'))
                ->when($this->status === "signed", fn($q) => $q->whereHas('task', fn($query) => $query->whereNotNull('signed_at')))
                ->when($this->status === "printed", fn($q) => $q->whereHas('task', fn($query) => $query->whereNotNull('printed_at')))
                ->when($this->status === "partial_paid_out", fn($q) => $q->has('transactions')->having("remaining_amount", '!=', 0))
                // filter coupon by coupons creation date
                ->when($this->created_at, fn($q) => $q->whereDate('created_at', $this->created_at_operator, $this->created_at))
                // filter coupon by coupons activation date
                ->when($this->activated_at, fn($q) => $q->whereDate('activated_at', $this->activated_at_operator, $this->activated_at))
                // filter coupon by coupons redeem date
                ->when($this->redeemed_at, fn($q) => $q->whereDate('redeemed_at', $this->redeemed_at_operator, $this->redeemed_at))
                // filter coupon by coupons sign date
                ->when($this->signed_at, fn($q) => $q->whereHas('task', fn($query) => $query->whereDate('signed_at', $this->signed_at_operator, $this->signed_at)))
                // filter coupon by coupons print date
                ->when($this->printed_at, fn($q) => $q->whereHas('task', fn($query) => $query->whereDate('printed_at', $this->printed_at_operator, $this->printed_at)))
                // filter coupon by coupons redeemed or not
                ->when($this->redeemed === "yes", fn($q) => $q->whereNotNull('redeemed_at'))
                ->when($this->redeemed === "no", fn($q) => $q->whereNull('redeemed_at'))
                // filter coupon by coupons booklet print cost free or paid if free then payment not apply and vice versa
                ->when($this->payment_applied !== "all", fn($q) => $q->whereHas('booklet', fn($query) => $query->whereLike(['print.type'], $this->payment_applied === "yes" ? "paid" : "free")))
                // filter coupon by coupons coming payout date
                ->when($this->payout_on, fn($q) => $q->whereDate('payout_on', $this->payout_on_operator, $this->payout_on))
                // filter coupon by coupons payout date
                ->when($this->payout_at, fn($q) => $q->whereDate('payout_at', $this->payout_at_operator, $this->payout_at))
                // filter coupon by coupons date left in coupon payment
                ->when($this->due_by !== "all", fn($q) => $q->whereDate('payout_on', $this->due_by_operator, now()->addDays((int) $this->due_by)))
                // filter coupon by coupons trasnactions metod
                ->when($this->transaction_method !== "both", fn($q) => $q->whereHas('transactions', fn($query) => $query->where('type', $this->transaction_method)))
                // filter coupon based on who paid the adlee commission
                ->when($this->fee_payer !== "either", fn($q) => $q->whereHas('transactions', fn($query) => $query->where('commission_paid', $this->fee_payer === "sponsor")))
                // filter coupon by coupons trasnactions fee
                ->when($this->transaction_fee, fn($q) => $q->whereHas('transactions', fn($query) => $query->where('service_fee_percentage', $this->transaction_fee_operator, $this->transaction_fee)))
                // filter coupon by coupons trasnactions fee percentage
                ->when($this->transaction_fee_cost, fn($q) => $q->whereHas('transactions', fn($query) => $query->where('service_fee', $this->transaction_fee_cost_operator, $this->transaction_fee_cost)))
                // filter coupon by coupons trasnactions credit card fee
                ->when($this->credit_card_fee, fn($q) => $q->whereHas('transactions', fn($query) => $query->where('transaction_fee_percentage', $this->credit_card_fee_operator, $this->credit_card_fee)->where('type', 'credit-card')))
                // filter coupon by coupons trasnactions credit card fee percentage
                ->when($this->credit_card_fee_cost, fn($q) => $q->whereHas('transactions', fn($query) => $query->where('transaction_fee', $this->credit_card_fee_cost_operator, $this->credit_card_fee_cost)->where('type', 'credit-card')))
                // filter coupon by coupons trasnactions ach
                ->when($this->ach_fee, fn($q) => $q->whereHas('transactions', fn($query) => $query->where('transaction_fee_percentage', $this->ach_fee_operator, $this->ach_fee)->where('type', 'ach')))
                // filter coupon by coupons trasnactions ach percentage
                ->when($this->ach_fee_cost, fn($q) => $q->whereHas('transactions', fn($query) => $query->where('transaction_fee', $this->ach_fee_cost_operator, $this->ach_fee_cost)->where('type', 'ach')))
                ->latest()
                ->paginate($this->perPage)
        ]);
    }


    public function updatedValue()
    {
        
        $this->filter = collect($this->filters)->filter(function ($item) {
            return $item['value'] === $this->value;
        })->first();
    }

    public function checkboxChanged($uuid, $value)
{
    if ($value) {
        if (!in_array($uuid, $this->checkedCoupons)) {
            $this->checkedCoupons[] = $uuid;
        }
    } else {
        $this->checkedCoupons = array_filter($this->checkedCoupons, fn($couponId) => $couponId !== $uuid);
    }

    // Store in session
    // session(['selectedCoupons' => $this->checkedCoupons]);

    // Refresh Livewire
    $this->dispatch('updatedCheckboxes');
}

}
