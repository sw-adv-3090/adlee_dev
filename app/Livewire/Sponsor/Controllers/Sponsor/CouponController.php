<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Coupon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sponsor.coupons.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sponsor.coupons.create');
    }

    /**
     * Show the details of resource.
     */
    public function show($id)
    {
        $coupon = Coupon::with(['sponsor', 'booklet', 'task', 'transactions'])->withSum('transactions', 'amount')->where('uuid', $id)->first();
        abort_if(is_null($coupon), 404);

        return view('sponsor.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        abort_if($coupon->user_id != auth()->id(), 403, 'Unathorized action');

        return view('sponsor.coupons.edit', compact('coupon'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        abort_if($coupon->user_id != auth()->id(), 403, 'Unathorized action');

        $coupon->delete();

        return back()->with('success', 'Coupon deleted successfully.');
    }
}
