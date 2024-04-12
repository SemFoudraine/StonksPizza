<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pizza;

class Pizzacontroller extends Controller
{



    public function index()
    {
        $pizzas = Pizza::all(); // Haal alle pizza's op uit de database
        $pizza_sizes = ['small', 'medium', 'large']; // Definieer de beschikbare maten

        return view('menu', compact('pizzas', 'pizza_sizes')); // Geef zowel $pizzas als $pizza_sizes door aan de view
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
