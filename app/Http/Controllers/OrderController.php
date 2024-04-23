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

        $user = Auth::user();

        $orders = Order::orderBy('id', 'desc')->where('user_id', $user->id)->get();

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
        $user = Auth::user();

        $order = new Order();
        $order->customer_name = $request->name;
        $order->customer_email = $request->email;
        $order->address = $request->street . ' ' . $request->house_number . ', ' . $request->zip_code . ' ' . $request->city;
        $order->total_price = $request->total_price;
        $order->user_id = $user->id;
        $order->status = 'Ontvangen';
        $order->save();

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

    public function cancel(Order $order)
    {
        $order->update([
            'status' => 'Geannuleerd'
        ]);

        return back()->with('success', 'Bestelling geannuleerd.');
    }
}
