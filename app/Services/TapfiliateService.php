<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Class TapfiliateService.
 */
class TapfiliateService
{

    protected $baseUrl, $apiKey;

    function __construct()
    {
        $this->baseUrl = config('services.tapfiliate.base_url');
        $this->apiKey = config('services.tapfiliate.api_key');
    }

    public function clicks($referral_code)
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Key' => $this->apiKey,
        ])->post(
                "$this->baseUrl/clicks/",
                [
                    'referral_code' => $referral_code
                ]
            )->json();
    }

    public function conversions($payload)
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Key' => $this->apiKey,
        ])->post(
                "$this->baseUrl/conversions/",
                [
                    "click_id" => $payload['clickId'],
                    "external_id" => $payload['externalId'],
                    "amount" => $payload['amount']
                ]
            )->json();
    }
}
