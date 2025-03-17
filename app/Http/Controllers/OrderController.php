<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Exception;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::all();
            return $this->successResponse($orders, 'Órdenes obtenidas correctamente');
        } catch (Exception $e) {
            return $this->errorResponse('Error al obtener órdenes', $e->getMessage());
        }
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            $order = Order::create($request->validated());
            return $this->successResponse($order, 'Orden creada correctamente', 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error al crear la orden', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $order = $this->findOrder($id);
            $order->load('products'); 
            return $this->successResponse($order, 'Orden obtenida correctamente');
        } catch (Exception $e) {
            return $this->errorResponse('Error al obtener la orden', $e->getMessage());
        }
    }

    public function update(UpdateOrderRequest $request, $id)
    {
        try {
            $order = $this->findOrder($id);
            $order->update($request->validated());
            return $this->successResponse($order, 'Orden actualizada correctamente');
        } catch (Exception $e) {
            return $this->errorResponse('Error al actualizar la orden', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $order = $this->findOrder($id);
            $order->delete();
            return $this->successResponse(null, 'Orden eliminada correctamente', 204);
        } catch (Exception $e) {
            return $this->errorResponse('Error al eliminar la orden', $e->getMessage());
        }
    }

    private function findOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            throw new Exception('Orden no encontrada');
        }
        return $order;
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