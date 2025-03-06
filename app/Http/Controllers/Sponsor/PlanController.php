<?php

namespace App\Http\Controllers\Sponsor;

use App\Enums\TemplateType;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('sponsor.flow.plans', [
            'plans' => Plan::whereType(TemplateType::SPONSOR->value)->whereStatus(true)->get()
        ]);
    }
}
