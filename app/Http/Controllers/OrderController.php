<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Pizza;
use App\Models\Ingredient;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $email = $user ? $user->email : $request->input('email');

        // Fetch orders based on user email address
        if ($email) {
            $orders = Order::orderBy('id', 'desc')->where('customer_email', $email)->get();
        } else {
            $orders = collect(); // Empty collection if no user or email
        }

        $orderItems = OrderItem::with('order')->get();

        return view('orders', [
            'orders' => $orders,
            'orderItems' => $orderItems,
        ]);
    }

    public function beheerIndex()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        $orderItems = OrderItem::with('order')->get();

        return view('beheer.bestellingen.orders', [
            'orders' => $orders,
            'orderItems' => $orderItems,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status bijgewerkt.');
    }

    public function store(Request $request)
    {
        try {
            // Controleer of de cart niet leeg is
            $cart = $request->input('cart', []);
            if (!is_array($cart)) {
                throw new \Exception('De winkelwagen moet een array zijn.');
            }

            if (empty($cart)) {
                throw new \Exception('De winkelwagen is leeg.');
            }

            // Maak een nieuwe order aan
            $order = new Order();
            $order->user_id = Auth::id();
            $order->customer_name = $request->input('name');
            $order->customer_email = $request->input('email');
            $order->customer_phone = $request->input('phone');
            $order->customer_address = $request->input('street');
            $order->customer_city = $request->input('city');
            $order->customer_zip = $request->input('zip_code');
            $order->total_price = $request->input('total_price');
            $order->save();

            // Verwerk elk item in de cart
            foreach ($cart as $cartItem) {
                // Maak een nieuw orderitem aan
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->pizza_name = $cartItem['name'];
                $orderItem->quantity = $cartItem['quantity'];
                $orderItem->price = $cartItem['price'];
                $orderItem->save();

                // Bevestig ingrediënten aan het orderitem
                if (isset($cartItem['ingredients']) && is_array($cartItem['ingredients'])) {
                    foreach ($cartItem['ingredients'] as $ingredientName) {
                        $ingredient = Ingredient::where('name', $ingredientName)->first();
                        if ($ingredient) {
                            $orderItem->ingredients()->attach($ingredient->id);
                        }
                    }
                }
            }

            return response()->json(['message' => 'Bestelling succesvol geplaatst!']);
        } catch (\Exception $e) {
            // Vang uitzonderingen op en geef een foutmelding weer
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function cancel(Order $order)
    {
        $order->update([
            'status' => 'Geannuleerd'
        ]);

        return back()->with('success', 'Bestelling geannuleerd.');
    }
}
