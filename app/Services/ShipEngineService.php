<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Class ShipEngineService.
 */
class ShipEngineService
{
    protected $baseUrl, $apiKey;

    function __construct()
    {
        $this->baseUrl = config('services.shipengine.base_url');
        $this->apiKey = config('services.shipengine.api_key');
    }

    // Implement ShipEngine API call to validate address
    public function validateAddress($arg)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Key' => $this->apiKey,
        ])->post(
                "$this->baseUrl/addresses/validate",
                [
                    [
                        'address_line1' => $arg['address_line1'],
                        'city_locality' => $arg['city_locality'],
                        'state_province' => $arg['state_province'],
                        'postal_code' => $arg['postal_code'],
                        'country_code' => $arg['country_code'],
                    ]
                ]
            )->json();

        if (is_array($response) && isset($response[0]['status']) && $response[0]['status'] == 'verified') {
            return true;
        }

        return false;
    }

    // Implement ShipEngine API call to fetch all carriers
    public function carriers()
    {
        $response = Http::withHeaders([
            'Api-Key' => $this->apiKey,
        ])->get(
                "$this->baseUrl/carriers",
            )->json();

        if (is_array($response) && isset($response['carriers']) && is_array($response['carriers']) && count($response['carriers']) > 0) {
            return $response['carriers'];
        }

        return [];
    }

    // Implement ShipEngine API call to create new label
    public function createLabel($arg)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Key' => $this->apiKey,
        ])->post(
                "$this->baseUrl/labels",
                [
                    "shipment" => [
                        "service_code" => $arg['service_code'],
                        "ship_from" => $arg['ship_from'],
                        "ship_to" => $arg['ship_to'],
                        "packages" => [
                            [
                                "weight" => [
                                    "value" => $arg['weight'],
                                    "unit" => "pound"
                                ],
                                "dimensions" => [
                                    "length" => $arg['length'],
                                    "width" => $arg['width'],
                                    "height" => $arg['height'],
                                    "unit" => "inch"
                                ],
                            ],
                        ],
                    ],
                ]
            )->json();

        return $response;
    }

    // Implement ShipEngine API call to create new label
    public function tracking(string $carrier_code, string $tracking_number)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Key' => $this->apiKey,
        ])->get(
                "$this->baseUrl/tracking?carrier_code=$carrier_code&tracking_number=$tracking_number",
            )->json();

        return $response;
    }
}
