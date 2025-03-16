<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'total' => 'required|numeric',
        ]);

        $order = Order::create($request->all());

        return response()->json($order, 201);
    }

    public function show($id)
    {
        return Order::with('products')->findOrFail($id); // Incluyendo los productos relacionados
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());

        return response()->json($order);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(null, 204);
    }
}
