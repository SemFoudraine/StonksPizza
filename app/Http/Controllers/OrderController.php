<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Haal de ingelogde gebruiker op
        $user = Auth::user();

        // Haal alleen de bestellingen op die aan de ingelogde gebruiker zijn gekoppeld
        $orders = $user->orders()->get();

        // Haal alle order items op inclusief gerelateerde orders
        $orderItems = OrderItem::with('order')->get();

        return view('orders', compact('orders', 'orderItems'));
    }
    public function store(Request $request)
    {
        // Hier wordt de huidige ingelogde gebruiker opgehaald
        $user = Auth::user();

        // Hier wordt de bestelling gemaakt met de user_id van de ingelogde gebruiker
        $order = new Order();
        $order->customer_name = $request->name;
        $order->customer_email = $request->email;
        $order->address = $request->street . ' ' . $request->house_number . ', ' . $request->zip_code . ' ' . $request->city;
        $order->total_price = $request->total_price;
        // Hier wordt de user_id ingesteld
        $order->user_id = $user->id;
        $order->save();

        // Rest van de code om items aan de bestelling toe te voegen...

        return response()->json(['message' => 'Order successfully placed.'], 200);
    }


    public function testApi() {
        return response()->json([
            'latitude' => '52.370216',
            'longitude' => '4.895168',
            'street' => 'Voorbeeldstraat',
            'city' => 'Amsterdam'
        ]);
    }
}
