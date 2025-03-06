<?php

namespace App\Http\Controllers\Sponsor;

use App\Enums\BookletPrintStatus;
use App\Enums\PaymentIntentStatus;
use App\Http\Controllers\Controller;
use App\Jobs\SendBookletForPrint;
use App\Models\Booklet;
use App\Models\BookletPrint;
use App\Models\Payment;
use App\Notifications\ShipmentCreatedNotification;
use Illuminate\Support\Facades\Notification;
use App\Services\ShipEngineService;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PrintBookletController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request, Booklet $booklet)
    {
        abort_if($booklet->user_id != auth()->id(), 403, 'Unathorized action');

        $user = $request->user();
        $plan = $user->plan();
        $printsCurrentMonth = $user->prints()->month()->count();
        $printBookletFee = $plan->booklet_fee;
        $bookletPgaes = $plan->booklet_pages;
        $freeBooklets = $plan->free_booklets;

        // check if user can create free print booklets
        if ($printsCurrentMonth < $freeBooklets) {
            return to_route('sponsors.booklets.print', ['booklet' => $booklet, 'amountPaid' => 0]);
        }

        // count booklet coupons
        $coupons = $booklet->coupons()->count();
        $printCharges = ceil($coupons / $bookletPgaes) * $printBookletFee;

        // charging user the print charges from the payment method
        $description = 'Printing booklet of ' . $coupons . ' coupons, charging $' . $printCharges;
        $args = [
            'stripe_customer_id' => $user->stripe_id,
            'amount' => $printCharges,
            'payment_method_id' => $user->stripe_payment_method_id,
            'description' => $description,
            'metadata' => ['print_booklet_url' => route('sponsors.booklets.print', $booklet)],
            'return_url' => route('checout-success'),
        ];
        $stripe = new StripeService();
        $intent = $stripe->payment_intent($args);

        // create payments record
        Payment::create([
            'user_id' => auth()->id(),
            'sponsor_id' => $booklet->sponsor_id,
            'payment_intent_id' => $intent->id,
            'amount' => $printCharges,
            'description' => $description,
            'status' => $intent->status
        ]);

        // payment is successfully charged, now proceed to print booklet
        if ($intent->status === PaymentIntentStatus::Succeeded->value) {
            return to_route('sponsors.booklets.print', ['booklet' => $booklet, 'amountPaid' => $printCharges]);
        }

        dd('unhandle method');

    }

    /**
     * Handle the incoming request.
     */
    public function print(Booklet $booklet, Request $request, ShipEngineService $service)
    {
        abort_if($booklet->user_id != auth()->id(), 403, 'Unathorized action');

        $booklet->load(['coupons.template:id,file,preview,meta_data,height,width', 'user:id,name,email', 'sponsor']);

        $data['service_code'] = settings('service_code');
        $data['ship_from'] = [
            'name' => settings('ship_from_name'),
            'company_name' => settings('ship_from_company_name'),
            'address_line1' => settings('ship_from_address'),
            'city_locality' => settings('ship_from_city'),
            'state_province' => getStateIsoCode(settings('ship_from_state')),
            'postal_code' => settings('ship_from_postal_code'),
            'country_code' => strtoupper(settings('ship_from_country')),
            'phone' => settings('ship_from_phone'),
        ];
        $data['ship_to'] = [
            'name' => $booklet->user?->name,
            'address_line1' => $booklet->sponsor?->shipping_address,
            'city_locality' => $booklet->sponsor?->shipping_city,
            'state_province' => getStateIsoCode($booklet->sponsor?->shipping_state),
            'postal_code' => $booklet->sponsor?->shipping_postal_code,
            'country_code' => strtoupper($booklet->sponsor?->shipping_country),
        ];
        $data['weight'] = settings('weight');
        $data['length'] = settings('length');
        $data['width'] = settings('width');
        $data['height'] = settings('height');

        // create shipengine label shipment
        $response = $service->createLabel($data);

        // if any error happened,
        if (isset($response['errors']) && count($response['errors']) > 0) {
            return redirect()->route('sponsors.booklets.index')->with('error', $response['errors'][0]['message']);
        } else {
            DB::transaction(function () use ($booklet, $request, $response) {
                $type = "paid";
                $user = request()->user();
                $plan = $user->plan();
                $printsCurrentMonth = $user->prints()->month()->count();
                $freeBooklets = $plan->free_booklets;
                if ($printsCurrentMonth < $freeBooklets) {
                    $type = "free";
                }
                $amountPaid = $request->has('amountPaid') ? (int) $request->get('amountPaid') : 0;

                // create database record for printing
                $bookletPrint = BookletPrint::create([
                    'user_id' => auth()->id(),
                    'booklet_id' => $booklet->id,
                    'status' => BookletPrintStatus::CREATED->value,
                    'type' => $type,
                    'amount_paid' => $amountPaid
                ]);

                $bookletPrint->load(['user.sponsor']);

                $bookletPrint->shipment()->create([
                    'label_id' => $response['label_id'],
                    'shipment_id' => $response['shipment_id'],
                    'tracking_number' => $response['tracking_number'],
                    'status' => $response['status'],
                    'carrier_id' => settings('carrier_id'),
                    'carrier_code' => $response['carrier_code'],
                    'service_code' => settings('service_code'),
                    'ship_date' => Carbon::parse($response['ship_date']),
                    'tracking_url' => $response['tracking_url'],
                    'tracking_status' => $response['tracking_status'],
                    'amount' => $response['shipment_cost']['amount'],
                    'download_pdf' => $response['label_download']['pdf'],
                    'download_png' => $response['label_download']['png'],
                    'download_zpl' => $response['label_download']['zpl'],
                ]);

                $bookletPrint->update(['status' => $response['tracking_status']]);

                // send notification mail to sponsor about the shipment
                Notification::send($bookletPrint->user, new ShipmentCreatedNotification($bookletPrint->user->name, $bookletPrint->booklet->number, $response['tracking_number'], $response['tracking_url']));

                // send print job to queue
                SendBookletForPrint::dispatch($booklet, $bookletPrint);
            });

            return redirect()->route('sponsors.booklets.index')->with('success', 'Booklet has been sent for printing');
        }
    }
}
