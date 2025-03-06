<?php

namespace App\Http\Controllers;

use App\Enums\TemplateType;
use App\Models\Plan;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Pricing Page.
     */
    public function pricing()
    {
        return view('website.pricing', [
            'plans' => Plan::whereType(TemplateType::SPONSOR->value)->whereStatus(true)->get()
        ]);
    }
}
