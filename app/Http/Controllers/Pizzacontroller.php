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

        // Valideer de data hier indien nodig

        // Verwerk en sla de pizza gegevens op
        $pizza = new Pizza();
        $pizza->name = $data['name'];
        $pizza->size = $data['size'];
        $pizza->customization = $data['customization'];
        $pizza->price = $data['price'];
        $pizza->ingredients = json_encode($data['ingredients']);
        $pizza->save();

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
