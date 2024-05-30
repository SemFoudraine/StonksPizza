<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pizza;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PizzasController extends Controller
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

        try {
            // Upload the image to public/img
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $path = $request->file('image')->move(public_path('img'), $imageName);

            // Log uploaded image name and path
            Log::info('Image uploaded: ' . $imageName . ' to path: ' . $path);

            // Save the pizza
            $pizza = new Pizza($request->only(['name', 'description', 'price', 'calories']));
            $pizza->image = 'img/' . $imageName;

            // Log pizza data before save
            Log::info('Pizza data before save: ', $pizza->toArray());

            $pizza->save();

            // Log pizza save success
            Log::info('Pizza saved: ' . $pizza->id);

            // Attach ingredients
            $pizza->ingredients()->attach($request->ingredients);

            // Log ingredient attachment
            Log::info('Ingredients attached to pizza: ' . $pizza->id);

            return redirect()->route('pizza.index')->with('success', 'Pizza is succesvol aangemaakt.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error saving pizza: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het opslaan van de pizza.');
        }
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
        $pizza = Pizza::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'calories' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ingredients' => 'required|array'
        ]);

        $pizza->name = $request->name;
        $pizza->description = $request->description;
        $pizza->price = $request->price;
        $pizza->calories = $request->calories;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($pizza->image) {
                Storage::delete('public/images/' . $pizza->image);
            }
            // Upload new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $imageName);
            $pizza->image = $imageName;
        }

        $pizza->save();

        // Sync ingredients
        $pizza->ingredients()->sync($request->ingredients);

        return redirect()->route('pizza.index')->with('success', 'Pizza succesvol bijgewerkt.');
    }

    public function destroy($id)
    {
        try {
            $pizza = Pizza::findOrFail($id);

            // Detach all related ingredients
            $pizza->ingredients()->detach();

            // Delete the pizza image
            if ($pizza->image) {
                Storage::delete('public/images/' . $pizza->image);
            }

            // Delete the pizza
            $pizza->delete();

            return redirect()->route('pizza.index')->with('success', 'Pizza succesvol verwijderd.');
        } catch (\Exception $e) {
            return redirect()->route('pizza.index')->with('error', 'Er is een fout opgetreden bij het verwijderen van de pizza.');
        }
    }
}
