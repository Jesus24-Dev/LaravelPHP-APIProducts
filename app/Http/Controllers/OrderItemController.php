<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use Exception;

class OrderItemController extends Controller
{

    public function index()
    {
        try {
            $orderItems = OrderItem::with(['order', 'product'])->get();
            return $this->successResponse($orderItems, 'Ítems de órdenes obtenidos correctamente');
        } catch (Exception $e) {
            return $this->errorResponse('Error al obtener los ítems de las órdenes', $e->getMessage());
        }
    }

    public function store(StoreOrderItemRequest $request)
    {
        try {
            $product = Product::findOrFail($request->product_id);

            $subtotal = $product->price * $request->quantity;

            $orderItem = OrderItem::create([
                'order_id' => $request->order_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'subtotal' => $subtotal,
            ]);

            $product->decrement('quantity', $request->quantity);

            $this->updateOrderTotal($request->order_id);

            return $this->successResponse($orderItem, 'Ítem de orden creado correctamente', 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error al crear el ítem de la orden', $e->getMessage());
        }
    }

    public function update(UpdateOrderItemRequest $request, $id)
    {
        try {
            $orderItem = $this->findOrderItem($id);
            $product = Product::findOrFail($orderItem->product_id);

            $product->increment('quantity', $orderItem->quantity);

            $newSubtotal = $product->price * $request->quantity;

            $orderItem->update([
                'quantity' => $request->quantity,
                'subtotal' => $newSubtotal,
            ]);

            $product->decrement('quantity', $request->quantity);

            $this->updateOrderTotal($orderItem->order_id);

            return $this->successResponse($orderItem, 'Ítem de orden actualizado correctamente');
        } catch (Exception $e) {
            return $this->errorResponse('Error al actualizar el ítem de la orden', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $orderItem = $this->findOrderItem($id);
            $product = Product::findOrFail($orderItem->product_id);

            $product->increment('quantity', $orderItem->quantity);

            $orderId = $orderItem->order_id;

            $orderItem->delete();

            $this->updateOrderTotal($orderId);

            return $this->successResponse(null, 'Ítem de orden eliminado correctamente', 204);
        } catch (Exception $e) {
            return $this->errorResponse('Error al eliminar el ítem de la orden', $e->getMessage());
        }
    }

    private function findOrderItem($id)
    {
        $orderItem = OrderItem::find($id);
        if (!$orderItem) {
            throw new Exception('Ítem de orden no encontrado');
        }
        return $orderItem;
    }

    private function updateOrderTotal($orderId)
    {
        $total = OrderItem::where('order_id', $orderId)->sum('subtotal');
        Order::where('id', $orderId)->update(['total_price' => $total]);
    }

    private function successResponse($data = null, $message = '', $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    private function errorResponse($error, $message, $statusCode = 500)
    {
        return response()->json([
            'success' => false,
            'error' => $error,
            'message' => $message,
        ], $statusCode);
    }
}