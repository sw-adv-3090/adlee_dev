<?php

namespace App\Http\Controllers\AdSpaceOwner;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class SignatureController extends Controller
{
    public function sign(Coupon $coupon)
    {
        $coupon->load(['task']);
        $documentId = $coupon->task->document_id;
        $error = "";
        $link = "";

        try {
            if (is_null($documentId)) {
                // Send request to Boldsign API to get document ID
                $response = Http::withHeaders([
                    'X-API-Key' => config('services.boldsign.api_key'),
                ])->post("https://api.boldsign.com/v1/template/send/?templateId=" . config('services.boldsign.template_id'), [
                            "roles" => [
                                [
                                    "roleIndex" => 1,
                                    "signerName" => auth()->user()->name,
                                    "signerEmail" => auth()->user()->email,
                                ]
                            ]

                        ])->json();

                if (isset($response['error'])) {
                    $error = $response['error'];
                } else {
                    $documentId = $response['documentId'];

                    $coupon->task->update(['document_id' => $documentId]);
                }
            }


            if (!$error) {
                // Get embed sign link from Boldsign API
                $queryString = http_build_query([
                    'DocumentId' => $documentId,
                    'SignerEmail' => auth()->user()->email,
                    'RedirectUrl' => "",
                    'DisableEmails' => true,
                ]);
                $headers = [
                    'X-API-Key' => config('services.boldsign.api_key'),
                ];
                $embedSignAPIUrl = "https://api.boldsign.com/v1/document/getEmbeddedSignLink?$queryString";
                $response = Http::withHeaders($headers)->get($embedSignAPIUrl)->json();

                if (isset($response['error'])) {
                    
                    $error = $response['error'];
                } else {
                    $link = $response['signLink'];
                }

                if (!$error) {
                    return view('ad-space-owner.coupons.sign', ['coupon' => $coupon, 'link' => $link]);
                }
            }

            return back()->with('error', $error);

        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }

    }

    public function download(Coupon $coupon)
    {
        $coupon->load(['task:coupon_id,document_id,signed_at']);

        if (is_null($coupon->task?->signed_at)) {
            return back()->with('error', 'Please provide e-signature consent first to download the template.');
        }

        $downloadDocumentAPIUrl = "https://api.boldsign.com/v1/document/download?documentId=" . $coupon->task->document_id;

        $headers = [
            'Accept' => 'application/json',
            'X-API-Key' => config('services.boldsign.api_key')
        ];

        $client = new Client(['verify' => false]);
        $response = $client->request('GET', $downloadDocumentAPIUrl, ['headers' => $headers]);

        if ($response->getStatusCode() == 200) {
            $fileContent = $response->getBody()->getContents();

            $fileName = "e-sign-" . $coupon->number . ".pdf";

            return Response::make($fileContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);
        }

        return back()->with('error', 'Something went wrong while downloading e-signature consent document.');
    }


    public function result(Request $request)
    {
        return response()->json([
            'success' => true,
            'response' => $request->all()
        ]);
    }
}
