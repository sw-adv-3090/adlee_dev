<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Booklet;
use Illuminate\Http\Request;

class BookletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();
        $plan = $user->plan();
        $printsCurrentMonth = $user->prints()->month()->count();
        $data['isOnBasicPlan'] = $plan->isOnBasicPlan();
        $data['bookletFee'] = $plan->booklet_fee;
        $data['bookletRemaining'] = $plan->free_booklets - $printsCurrentMonth;

        return view('sponsor.booklets.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        $booklet = $request->input('booklet',null);
        $wizard_view = $request->input('wizard_view',null);
        // if($booklet && $wizard_view !='completed'){
        //     $booklet = Booklet::find($bookletId);
        // }
            
        return view('sponsor.booklets.create',compact( 'booklet','wizard_view'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Booklet $booklet)
    {
        abort_if($booklet->user_id != auth()->id(), 403, 'Unathorized action');

        return view('sponsor.booklets.show', compact('booklet'));
    }

}
