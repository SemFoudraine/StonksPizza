<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pizza;
use App\Models\Ingredient;
class Pizzacontroller extends Controller
{



    public function index()
    {
        $pizzas = Pizza::all();
        $pizza_sizes = ['small', 'medium', 'large'];
        $ingredients = Ingredient::all();

        return view('menu', compact('pizzas', 'pizza_sizes', 'ingredients'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->all();

        // Controleer eerst of de sessie variabele cart bestaat
        $cart = session()->get('cart', []);

        // Voeg de ontvangen pizza toe aan de winkelwagen
        $cart[] = [
            'name' => $data['name'],
            'size' => $data['size'],
            'customization' => $data['customization'],
            'price' => $data['price'],
            'ingredients' => $data['ingredients']
        ];

        // Sla de bijgewerkte winkelwagen op in de sessie variabele cart
        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }



    public function bedankt()
    {
        return view('bedankt');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
