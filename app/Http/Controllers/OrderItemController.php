<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        $subtotal = $product->price * $request->quantity;
 
        $orderItem = OrderItem::create([
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'subtotal' => $subtotal
        ]);

        $product->decrement('quantity', $request->quantity);

        $this->updateOrderTotal($request->order_id);

        return response()->json($orderItem, 201);
    }

    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $product = Product::findOrFail($orderItem->product_id);


        $product->increment('quantity', $orderItem->quantity);

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $newSubtotal = $product->price * $request->quantity;

        $orderItem->update([
            'quantity' => $request->quantity,
            'subtotal' => $newSubtotal,
        ]);

        $product->decrement('quantity', $request->quantity);

        $this->updateOrderTotal($orderItem->order_id);

        return response()->json($orderItem);
    }

    public function destroy($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $product = Product::findOrFail($orderItem->product_id);

        $product->increment('quantity', $orderItem->quantity);

        $orderId = $orderItem->order_id;

        $orderItem->delete();

        $this->updateOrderTotal($orderId);

        return response()->json(null, 204);
    }

    private function updateOrderTotal($orderId)
    {
        $total = OrderItem::where('order_id', $orderId)->sum('subtotal');
        Order::where('id', $orderId)->update(['total_price' => $total]);
    }
}
