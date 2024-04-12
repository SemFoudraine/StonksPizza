<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{
    public function fetchAddress(Request $request)
    {
        $client = new Client();

        // Zorg ervoor dat de postcode en het huisnummer correct zijn geformatteerd
        $postcode = strtoupper(str_replace(' ', '', $request->query('postcode')));
        $number = $request->query('number');

        try {
            $response = $client->request('GET', "https://postcode.tech/api/v1/postcode/full?postcode=$postcode&number=$number", [
                'headers' => [
                    'Authorization' => 'Bearer 4bd4a64d-fdb5-4cc3-8bff-971740333e40'
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return response()->json([
                'street' => $data['street'] ?? null,
                'city' => $data['city'] ?? null,
                'municipality' => $data['municipality'] ?? null,
                'province' => $data['province'] ?? null,
                'latitude' => $data['geo']['lat'] ?? null,
                'longitude' => $data['geo']['lon'] ?? null,
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error("Fout bij het ophalen van adres: " . $e->getMessage());
            return response()->json(['error' => 'Er is iets misgegaan bij het ophalen van de adresgegevens.'], 500);
        }
    }
}
