<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

/**
 * Class TinCorrectService.
 */
class TinCorrectService
{
    private string $baseUrl = "";
    private string $token = "";
    private Client $guzzle;

    function __construct()
    {
        $this->baseUrl = config('services.tincorrect.base_url');

        $this->setToken();
    }

    public function validateTin(string $ein, string $name)
    {
        try {
            $id = Http::withToken($this->token)->post($this->baseUrl . '/TinRequest', [
                'Tin' => $ein,
                'Name' => $name,
            ])->json();

            if (!is_numeric($id)) {
                return [
                    'success' => false,
                    'message' => 'We are unable to verify your EIN number. Please try again.',
                ];
            }

            $category = null;
            do {
                $results = $this->getTinResults($id);
                $category = $results['resultCategory'];
                if (empty($category)) {
                    sleep(2); // API Requirement
                }
            } while (empty($category));

            return $category === 'match' ? [
                'success' => true,
                'message' => 'You are successfully verified.',
            ] : [
                'success' => false,
                'message' => $results['resultDescription'],
            ];

        } catch (RequestException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getTinResults(int $id)
    {
        return Http::withToken($this->token)->get($this->baseUrl . '/TinRequest/' . $id)->json();
    }

    public function setToken()
    {
        // $this->token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9uYW1lIjoiZGFubnlzQGpldHdhdmVzZXJ2aWNlcy5jb20iLCJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcy9uYW1laWRlbnRpZmllciI6ImU1NTJiMTZlLTk5ODAtNGRhMC1iMjgyLTllNmMzYzE2N2U1OSIsImV4cCI6MTcxNzczNzA2MywiaXNzIjoiaHR0cHM6Ly9ib29tdGF4LmNvbSIsImF1ZCI6Imh0dHBzOi8vYm9vbXRheC5jb20ifQ.-biEbf5f6MB5ipWok45mqRDHTTZGwyuo5QEtqCAcNuA";

        $response = Http::post($this->baseUrl . '/Token/', [
            'username' => config('services.tincorrect.username'),
            'password' => config('services.tincorrect.password'),
            'grant_type' => 'password',
        ])->json();

        $this->token = $response['access_token'];
    }
}
