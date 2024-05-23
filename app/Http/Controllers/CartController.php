<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $data = $request->all();

        $pizza = Pizza::create([
            'name' => $data['name'],
            'size' => $data['size'],
            'customization' => $data['customization'],
            'price' => $data['price'],
            'ingredients' => $data['ingredients']
        ]);

        return response()->json(['success' => true]);
    }
}
