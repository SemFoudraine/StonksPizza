<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = new Order();
        $order->customer_name = $request->name;
        $order->customer_email = $request->email;
        $order->address = $request->street . ' ' . $request->house_number . ', ' . $request->zip_code . ' ' . $request->city;
        $order->total_price = $request->total_price; // Haal de totaalprijs van het formulier
        $order->save();

        // Decodeer de JSON-string van de winkelwagenitems
        $cartItems = json_decode($request->cart, true);
        foreach ($cartItems as $item) {
            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'pizza_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity']
            ]);
            $orderItem->save();
        }

        return response()->json(['message' => 'Order successfully placed.'], 200);
    }
}
