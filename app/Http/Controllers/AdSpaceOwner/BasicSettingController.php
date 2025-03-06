<?php

namespace App\Http\Controllers\AdSpaceOwner;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdSpaceOwner\CompanyInfoRequest;
use App\Models\AdSpaceOwner;
use Illuminate\Http\Request;

class BasicSettingController extends Controller
{
    private $user, $adSpaceOwner;

    /**
     * Initializes the controller constructor
     */
    public function __construct()
    {
        $this->user = request()->user();
        $this->adSpaceOwner = request()->user()->adSpaceOwner;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ad-space-owner.basic-settings.index', ['adSpaceOwner' => $this->adSpaceOwner]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyInfoRequest $request)
    {
        // save company information
        AdSpaceOwner::updateOrCreate([
            'user_id' => $this->user->id,
        ], [
            'user_id' => $this->user->id,
            ...$request->validated()
        ]);

        return redirect()->route('ad-space-owner.basic-settings.ein.index')->with('success', 'Company information updated successfully.');
    }
}
