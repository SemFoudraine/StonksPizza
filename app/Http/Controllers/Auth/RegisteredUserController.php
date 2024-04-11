<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'phone' => ['required', 'string'],
            'woonplaats' => ['required', 'string'],
            'postcode' => ['required', 'string'],
            'adres' => ['required', 'string'],
            'huisnummer' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'woonplaats' => $request->woonplaats,
            'postcode' => $request->postcode,
            'adres' => $request->adres,
            'huisnummer' => $request->huisnummer,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

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
