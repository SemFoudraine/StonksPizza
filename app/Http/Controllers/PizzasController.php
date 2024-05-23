<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pizza;
use App\Models\Ingredient;

class Pizzascontroller extends Controller
{
    public function index()
{
    $pizzas = Pizza::with('ingredients')->get();
    $ingredients = Ingredient::all();
    return view('beheer.pizzas.index', compact('pizzas', 'ingredients'));
}

    public function create()
    {
        $ingredients = Ingredient::all();
        return view('beheer.pizzas.create', compact('ingredients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'calories' => 'nullable|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ingredients' => 'required|array'
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->storeAs('public/images', $imageName);

        $pizza = new Pizza($request->only(['name', 'description', 'price', 'calories']));
        $pizza->image = $imageName;
        $pizza->save();
        $pizza->ingredients()->attach($request->ingredients);

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
        $ingredients = Ingredient::all();
        return view('beheer.pizzas.edit', compact('pizza', 'ingredients'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'calories' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ingredients' => 'required|array'
        ]);

        $pizza = Pizza::findOrFail($id);
        $pizza->update($request->only(['name', 'description', 'price', 'calories']));

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->storeAs('public/images', $imageName);
            $pizza->image = $imageName;
        }

        $pizza->ingredients()->sync($request->ingredients);
        $pizza->save();

        return redirect()->route('pizza.index')->with('success', 'Pizza is succesvol bijgewerkt.');
    }

    public function destroy(Pizza $pizza)
    {
        $pizza->delete();
        return redirect()->route('pizza.index')->with('success', 'Pizza is succesvol verwijderd.');
    }
}
