<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'subtotal' => 'required|numeric',
        ]);

        $orderItem = OrderItem::create($request->all());

        return response()->json($orderItem, 201);
    }

    public function show($id)
    {
        return OrderItem::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update($request->all());

        return response()->json($orderItem);
    }

    public function destroy($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();

        return response()->json(null, 204);
    }
}