<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $pizzaId = $request->input('pizza_id');
        $quantity = $request->input('quantity', 1);

        $pizza = Pizza::find($pizzaId);

        if (!$pizza) {
            return back()->with('error', 'Pizza niet gevonden.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$pizzaId])) {
            $cart[$pizzaId]['quantity'] += $quantity;
        } else {
            $cart[$pizzaId] = [
                'name' => $pizza->name,
                'price' => $pizza->price,
                'quantity' => $quantity,
                'image' => $pizza->image
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Pizza toegevoegd aan winkelwagen.');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item verwijderd uit winkelwagen.');
    }
}
