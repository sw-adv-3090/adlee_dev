<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use App\Services\StripePriceService;
use App\Services\StripeProductService;
use DB;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.plans.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.plans.create', ['types' => UserType::cases()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // create new plan
                $data = $request->validated();
                $data['specifications'] = [];
                $plan = Plan::create($data);

                // create stripe produc
                $stripeProduct = (new StripeProductService())->create($request->name);

                // create stripe price
                $stripePrice = (new StripePriceService())->create($stripeProduct->id, $request->price);

                // update stripe product and price to $plan
                $plan->update(['stripe_product_id' => $stripeProduct->id, 'stripe_price_id' => $stripePrice->id]);
            });

            return back()->with('success', 'Plan created successfully.');

        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', ['plan' => $plan, 'types' => UserType::cases()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanRequest $request, Plan $plan)
    {
        try {
            DB::transaction(function () use ($request, $plan) {
                $isNameUpdated = $plan->name !== $request->name;
                $isPriceUpdated = $plan->price != $request->price;

                // update stripe product
                if ($isNameUpdated) {
                    (new StripeProductService())->update($plan->stripe_product_id, $request->name);
                }

                // update stripe price
                if ($isPriceUpdated) {
                    (new StripePriceService())->update($plan->stripe_price_id, $request->price);
                }

                // update plan
                $data = $request->validated();
                $data['specifications'] = [];
                $plan->update($data);

            });
            return back()->with('success', 'Plan updated successfully.');
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage())->withInput();
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        try {
            // delete $plan
            $plan->delete();

            return back()->with('success', 'Plan deleted successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
