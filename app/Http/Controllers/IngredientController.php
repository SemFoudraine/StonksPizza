<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('beheer.ingredient.index', compact('ingredients'));
    }

    public function store(Request $request)
    {
        $ingredient = new Ingredient();
        $ingredient->name = $request->name;
        $ingredient->save();

        return redirect()->route('ingredient.index')->with('success', 'Ingrediënt is toegevoegd!');
    }

    public function edit(Ingredient $ingredient)
    {
        return view('beheer.ingredient.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $ingredient->name = $request->name;
        $ingredient->save();

        return redirect()->route('ingredient.index')->with('success', 'Ingrediënt is bijgewerkt!');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return redirect()->route('ingredient.index')->with('success', 'Ingrediënt is verwijderd!');
    }
}
