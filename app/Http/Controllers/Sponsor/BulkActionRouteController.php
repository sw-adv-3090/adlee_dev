<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BulkActionRouteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ($request->type === "coupons") {
            return response()->json([
                'success' => true,
                'activate' => route('sponsors.coupons.activate.bulk.index', ['coupons' => $request->couponIds]),
                'payout' => route('sponsors.coupons.payout.bulk', ['coupons' => $request->couponIds]),
            ]);
        } else if ($request->type === "booklets") {
            return response()->json([
                'success' => true,
                'activate' => route('sponsors.booklets.bulk.activate.index', ['booklets' => $request->bookletIds]),
            ]);
        }
    }
}
