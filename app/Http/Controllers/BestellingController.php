<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bestelling;
use Illuminate\Http\Response;

class BestellingController extends Controller
{
    /**
     * Plaats een nieuwe bestelling.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function plaatsBestelling(Request $request)
    {
        // Valideer de invoergegevens
        $validatedData = $request->validate([
            'pizza_name' => 'required|string',
            // Voeg hier andere validatieregels toe voor andere velden
        ]);

        // Maak een nieuwe bestelling aan
        $bestelling = new Bestelling();

        // Vul de velden van de bestelling in met de gegevens uit het formulier
        $bestelling->pizza_name = $request->input('pizza_name');
        // Voeg hier andere velden toe zoals grootte, aanpassingen, enz.

        // Sla de bestelling op in de database
        $bestelling->save();

        // Redirect de gebruiker naar een bevestigingspagina of een andere pagina
        return redirect()->route('bedankt')->with('status', 'Bedankt voor uw bestelling!');
    }

    /**
     * Toon een lijst van alle bestellingen.
     *
     * @return \Illuminate\Http\Response
     */
    public function toonBestellingen()
    {
        // Haal alle bestellingen op uit de database
        $bestellingen = Bestelling::all();

        // Geef de bestellingen door aan de view om weer te geven
        return response()->view('bestellingen.index', ['bestellingen' => $bestellingen]);
    }
}
