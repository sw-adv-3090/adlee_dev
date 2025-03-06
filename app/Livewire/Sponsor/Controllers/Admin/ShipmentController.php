<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookletPrint;
use App\Notifications\ShipmentCreatedNotification;
use App\Services\ShipEngineService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Notification;

class ShipmentController extends Controller
{
    public function index(BookletPrint $job, ShipEngineService $service)
    {
        $job->load(['booklet:id,title,number', 'booklet.coupons:booklet_id', 'shipment']);
        $carriers = cache()->remember('carriers', 3600, fn() => $service->carriers());

        return view('admin.jobs.show', ['job' => $job, 'carriers' => $carriers]);
    }

    public function store(Request $request, BookletPrint $job, ShipEngineService $service)
    {
        $job->load(['user.sponsor']);

        $data['service_code'] = $request->get('service_code');
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
            'name' => $job->user?->name,
            'address_line1' => $job->user?->sponsor?->shipping_address,
            'city_locality' => $job->user?->sponsor?->shipping_city,
            'state_province' => getStateIsoCode($job->user?->sponsor?->shipping_state),
            'postal_code' => $job->user?->sponsor?->shipping_postal_code,
            'country_code' => strtoupper($job->user?->sponsor?->shipping_country),
        ];
        $data['weight'] = $request->get('weight');
        $data['length'] = $request->get('length');
        $data['width'] = $request->get('width');
        $data['height'] = $request->get('height');

        // dd($data);

        // create shipengine label shipment
        $response = $service->createLabel($data);
        // dd($response);

        // if any error happened,
        if (isset($response['errors']) && count($response['errors']) > 0) {
            return back()->with('error', $response['errors'][0]['message'])->withInput();
        } else {
            DB::transaction(function () use ($job, $request, $response) {
                $job->shipment()->create([
                    'label_id' => $response['label_id'],
                    'shipment_id' => $response['shipment_id'],
                    'tracking_number' => $response['tracking_number'],
                    'status' => $response['status'],
                    'carrier_id' => $request->get('carrier_id'),
                    'service_code' => $request->get('service_code'),
                    'ship_date' => Carbon::parse($response['ship_date']),
                    'tracking_url' => $response['tracking_url'],
                    'tracking_status' => $response['tracking_status'],
                    'amount' => $response['shipment_cost']['amount'],
                    'download_pdf' => $response['label_download']['pdf'],
                    'download_png' => $response['label_download']['png'],
                    'download_zpl' => $response['label_download']['zpl'],
                ]);

                $job->update(['status' => $response['tracking_url']]);

                // send notification mail to sponsor about the shipment
                Notification::send($job->user, new ShipmentCreatedNotification($job->user->name, $job->booklet->number, $response['tracking_number'], $response['tracking_url']));
            });


            return back()->with('success', 'Booklet successfully shipped!');
        }


    }
}
