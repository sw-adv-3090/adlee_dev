<?php

namespace App\Livewire\AdSpaceOwner\Coupons;

use App\Livewire\Paginator;
use App\Models\Coupon;

class Index extends Paginator
{
    public string $coupon_id = "";

    public function mount()
    {
        if (request()->has('coupon_id')) {
            $this->coupon_id = request()->query('coupon_id');
            // check wether the user signed the document or not, if yes then update database
            $coupon = Coupon::with(['task:id,coupon_id,document_id,signed_at,printed_at'])->select(['id', 'uuid'])->where('uuid', $this->coupon_id)->first();
            abort_if(is_null($coupon), 404);
            if (is_null($coupon->task?->signed_at)) {
                $response = sign_task($coupon);
                // if success fully signed then go to print the remplate page
                if ($response) {
                    return redirect()->route('ad-space-owner.coupons.task.print.index', $coupon->uuid);
                }
            }

            // redirect always to print template if not printed yet
            if (is_null($coupon->task?->printed_at)) {
                return redirect()->route('ad-space-owner.coupons.task.print.index', $coupon->uuid);
            }

        }
    }

    public function render()
    {
        return view('livewire.ad-space-owner.coupons.index', [
            'coupons' => Coupon::query()
                ->with(['task:id,coupon_id,printed_at,signed_at,template_id', 'transactions:coupon_id,amount,created_at'])
                ->withSum('transactions', 'amount')
                ->where('redeemed_by', auth()->user()->email)
                ->whereNotNull('activated_at')
                ->when($this->coupon_id, fn($q) => $q->where('uuid', $this->coupon_id))
                ->when($this->search, fn($q) => $q->whereLike(['title', 'number'], $this->search))
                ->paginate($this->limit)
        ]);
    }

    public function redeemCoupon($coupon){
        dd('here');
        return redirect()->route('ad-space-owner.coupons.redeem.index', $coupon);
    }
}
