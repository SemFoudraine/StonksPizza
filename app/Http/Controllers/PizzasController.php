<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pizza;

class Pizzascontroller extends Controller
{
public function index()
{
    $pizzas = Pizza::all();
    return view('beheer.pizzas.index', compact('pizzas'));
}

public function create()
{
    return view('beheer.pizzas.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'calories' => 'nullable|integer|min:0', // Maak het veld optioneel
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imageName = time().'.'.$request->image->extension();
    $request->image->storeAs('public/images', $imageName);

    $pizza = new Pizza();
    $pizza->name = $request->name;
    $pizza->description = $request->description;
    $pizza->price = $request->price;
    $pizza->image = $imageName;
    $pizza->save();

    return redirect()->route('pizza.index')->with('success', 'Pizza is succesvol aangemaakt.');
}


public function show($id)
{
    $pizza = Pizza::findOrFail($id);
    return view('beheer.pizzas.show', compact('pizza'));
}

public function edit($id)
{
    $pizza = Pizza::findOrFail($id);
    return view('beheer.pizzas.edit', compact('pizza'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $pizza = Pizza::findOrFail($id);
    $pizza->name = $request->name;
    $pizza->description = $request->description;
    $pizza->price = $request->price;

    if ($request->hasFile('image')) {
        $imageName = time().'.'.$request->image->extension();
        $request->image->storeAs('public/images', $imageName);
        $pizza->image = $imageName;
    }

    $pizza->save();

    return redirect()->route('pizza.index')->with('success', 'Pizza is succesvol bijgewerkt.');
}

public function destroy($id)
{
    $pizza = Pizza::findOrFail($id);
    $pizza->delete();
    return redirect()->route('pizza.index')->with('success', 'Pizza is succesvol verwijderd.');
}
}
