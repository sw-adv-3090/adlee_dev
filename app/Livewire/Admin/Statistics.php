<?php

namespace App\Livewire\Admin;

use App\Enums\UserRole;
use App\Models\Booklet;
use App\Models\BookletPrint;
use App\Models\Coupon;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Number;

class Statistics extends Component
{
    public $start, $end;

    public function render()
    {
        $paymentProcess = Transaction::when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->sum('paid_amount');
        $commission = Transaction::when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->sum('service_fee');
        $stripeFee = Transaction::when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->sum('transaction_fee');
        $sponsors = User::where('role_id', UserRole::Sponsor->value)->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $adSpaceOwners = User::where('role_id', UserRole::AdSpaceOwner->value)->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $booklets = Booklet::when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $tickets = Coupon::when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $freeBooklets = BookletPrint::where('type', 'free')->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $ticketsPrinted = Task::whereNotNull('printed_at')->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $ticketsPaid = Coupon::whereNotNull('payout_at')->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $ticketsPartialPaid = Coupon::whereNull('payout_at')->whereHas('transactions')->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $ticketsPaymentFailed = Coupon::where('failed_tries', 3)->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $ticketsRedeemed = Coupon::whereNotNull('redeemed_by')->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $ticketsRedeemedPending = Coupon::whereNull('redeemed_by')->whereNotNull('activated_at')->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $ticketsActivationPending = Coupon::whereNull('activated_at')->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $ticketsPendingSigned = Task::whereNull('signed_at')->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $ticketsPendingPrinting = Task::whereNull('printed_at')->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $ticketsActive = Task::whereNotNull(['template_id', 'printed_at'])->whereHas('coupon', fn($q) => $q->whereNull('payout_at'))->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $sponsorCancellation = User::where('role_id', UserRole::Sponsor->value)->whereDoesntHave('subscriptions', fn($q) => $q->active())->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();
        $adSpaceOwnerCancellation = User::where('role_id', UserRole::AdSpaceOwner->value)->whereDoesntHave('subscriptions', fn($q) => $q->active())->when($this->start && $this->end, fn($q) => $q->whereBetween('created_at', [$this->start, $this->end]))->count();

        return view('livewire.admin.statistics', [
            'paymentProcessed' => Number::abbreviate($paymentProcess, precision: 2),
            'commission' => Number::abbreviate($commission, precision: 2),
            'stripeFee' => Number::abbreviate($stripeFee, precision: 2),
            'sponsors' => Number::abbreviate($sponsors),
            'adSpaceOwners' => Number::abbreviate($adSpaceOwners),
            'booklets' => Number::abbreviate($booklets),
            'tickets' => Number::abbreviate($tickets),
            'freeBooklets' => Number::abbreviate($freeBooklets),
            'ticketsPrinted' => Number::abbreviate($ticketsPrinted),
            'ticketsPaid' => Number::abbreviate($ticketsPaid),
            'ticketsPartialPaid' => Number::abbreviate($ticketsPartialPaid),
            'ticketsPaymentFailed' => Number::abbreviate($ticketsPaymentFailed),
            'ticketsRedeemed' => Number::abbreviate($ticketsRedeemed),
            'ticketsRedeemedPending' => Number::abbreviate($ticketsRedeemedPending),
            'ticketsActivationPending' => Number::abbreviate($ticketsActivationPending),
            'ticketsPendingSigned' => Number::abbreviate($ticketsPendingSigned),
            'ticketsPendingPrinting' => Number::abbreviate($ticketsPendingPrinting),
            'ticketsActive' => Number::abbreviate($ticketsActive),
            'sponsorCancellation' => Number::abbreviate($sponsorCancellation),
            'adSpaceOwnerCancellation' => Number::abbreviate($adSpaceOwnerCancellation),
        ]);
    }

    // public function updatedStart()
    // {
    //     dd($this->start);
    // }
    // public function updatedEnd()
    // {
    //     dd($this->end);
    // }
}
