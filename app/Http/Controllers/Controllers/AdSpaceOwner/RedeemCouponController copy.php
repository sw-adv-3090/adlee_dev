<?php

namespace App\Http\Controllers\AdSpaceOwner;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class RedeemCouponController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        // $documentId = "542af056-5cb1-465c-b53e-0b9cd0602d1e";
        $documentId = "5e8aa807-3bc4-4fe4-b0a6-7a967764d708";
        $link = "https://app.boldsign.com/document/sign/?documentId=5e8aa807-3bc4-4fe4-b0a6-7a967764d708s_m3j30;bec23e7f-0f20-4427-bb30-4d4604e53621";
        // $response = Http::withHeaders([
        //     'X-API-Key' => config('services.boldsign.api_key'),
        // ])->post("https://api.boldsign.com/v1/template/send/?templateId=" . config('services.boldsign.template_id'), [
        //             "roles" => [
        //                 [
        //                     "roleIndex" => 1,
        //                     "signerName" => "Sylvester Underwood",
        //                     "signerEmail" => "doxywavoc@mailinator.com",
        //                 ]
        //             ]

        //         ]);

        // $queryString = http_build_query([
        //     'DocumentId' => $documentId,
        //     'SignerEmail' => "doxywavoc@mailinator.com",
        //     'RedirectUrl' => route('ad-space-owner.dashboard')
        // ]);
        // $headers = [
        //     'X-API-Key' => config('services.boldsign.api_key'),
        // ];
        // $embedSignAPIUrl = "https://api.boldsign.com/v1/document/getEmbeddedSignLink?$queryString";
        // $response = Http::withHeaders($headers)->get($embedSignAPIUrl);

        // dd($response->json());

        // $downloadDocumentAPIUrl = "https://api.boldsign.com/v1/document/download?documentId=" . $documentId;

        // $headers = [
        //     'Accept' => 'application/json',
        //     'X-API-Key' => config('services.boldsign.api_key')
        // ];

        // $client = new Client(['verify' => false]);
        // $response = $client->request('GET', $downloadDocumentAPIUrl, ['headers' => $headers]);

        // if ($response->getStatusCode() == 200) {
        //     $fileContent = $response->getBody()->getContents();

        //     return Response::make($fileContent, 200, [
        //         'Content-Type' => 'application/pdf',
        //         'Content-Disposition' => 'attachment; filename="document.pdf"'
        //     ]);
        // }

        // dd('Could not download');

        abort_if($coupon->redeemed_by !== auth()->user()->email, 403);
        abort_if(!is_null($coupon->redeemed_at), 401, 'Coupon already redeemed.');
        $coupon->load(['sponsor:id,company_name']);

        return view('ad-space-owner.coupons.redeem', compact('coupon'));
    }

    /**
     * Select template for the specified coupon.
     */
    public function templates(Request $request, Coupon $coupon)
    {
        abort_if($coupon->redeemed_by !== auth()->user()->email, 403);
        abort_if(!is_null($coupon->redeemed_at), 401, 'Coupon already redeemed.');
        $coupon->load(['task']);

        return view('ad-space-owner.coupons.template', compact('coupon'));
    }


    /**
     * Redeem the specified coupon.
     */
    public function redeem(Request $request, Coupon $coupon)
    {
        dd($request->all());
    }

}
