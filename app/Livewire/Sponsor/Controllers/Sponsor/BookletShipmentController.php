<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Booklet;
use Illuminate\Http\Request;

class BookletShipmentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Booklet $booklet)
    {
        $booklet->load(['prints.shipment']);

        abort_if($booklet->user_id !== auth()->id(), 403);

        abort_if($booklet->prints->count() == 0, 404);

        return view('sponsor.booklets.prints', compact('booklet'));
    }
}
