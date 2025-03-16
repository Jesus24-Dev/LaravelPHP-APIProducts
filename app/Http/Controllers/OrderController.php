<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'total_price' => 'required|numeric|min:0',
        ]);

        $order = Order::create($request->all());

        return response()->json(['message' => 'Order created', 'order' => $order], 201);
    }

    public function show($id)
    {
        $order = Order::with('products')->find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json($order, 200);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $request->validate([
            'total_price' => 'required|numeric|min:0',
        ]);

        $order->update($request->all());

        return response()->json(['message' => 'Order updated', 'order' => $order], 200);
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted'], 204);
    }
}
