<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Pizza;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $email = $request->input('email');

        // Fetch orders based on user ID or email address
        if ($user) {
            $orders = Order::orderBy('id', 'desc')->where('user_id', $user->id)->get();
        } elseif ($email) {
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
        // Check if the user is authenticated
        $user = Auth::user();

        // Create a new order instance
        $order = new Order();
        $order->customer_name = $request->name;
        $order->customer_email = $request->email;
        $order->address = $request->street . ' ' . $request->house_number . ', ' . $request->zip_code . ' ' . $request->city;
        $order->total_price = $request->total_price;

        // Set the user_id to null if the user is not authenticated
        $order->user_id = $user ? $user->id : null;
        $order->status = 'Ontvangen';
        $order->save();

        // Decode the cart items from the request
        $cartItems = json_decode($request->cart, true);

        // Iterate through each cart item and save it as an OrderItem
        foreach ($cartItems as $item) {
            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'pizza_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity']
            ]);
            $orderItem->save();

            // Handle ingredients
            if (isset($item['ingredients']) && is_array($item['ingredients'])) {
                // Find the pizza by its name
                $pizza = Pizza::where('name', $item['name'])->first();
                if ($pizza) {
                    // Attach the ingredients to the order item
                    $pizza->ingredients()->attach($item['ingredients']);
                }
            }
        }

        // Return a success response
        return response()->json(['message' => 'Order successfully placed.'], 200);
    }


    public function cancel(Order $order)
    {
        $order->update([
            'status' => 'Geannuleerd'
        ]);

        return back()->with('success', 'Bestelling geannuleerd.');
    }
}
