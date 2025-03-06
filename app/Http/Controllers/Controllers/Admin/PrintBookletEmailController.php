<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;

class PrintBookletEmailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SettingRequest $request)
    {
        dd($request->all());
    }
}
