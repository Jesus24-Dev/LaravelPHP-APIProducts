<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Exception;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::all();
            return $this->successResponse($products, 'Productos obtenidos correctamente');
        } catch (Exception $e) {
            return $this->errorResponse('Error al obtener productos', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $product = $this->findProduct($id);
            return $this->successResponse($product, 'Producto obtenido correctamente');
        } catch (Exception $e) {
            return $this->errorResponse('Error al obtener el producto', $e->getMessage());
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());
            return $this->successResponse($product, 'Producto creado correctamente', 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error al crear el producto', $e->getMessage());
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $product = $this->findProduct($id);
            $product->update($request->validated());
            return $this->successResponse($product, 'Producto actualizado correctamente');
        } catch (Exception $e) {
            return $this->errorResponse('Error al actualizar el producto', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $product = $this->findProduct($id);
            $product->delete();
            return $this->successResponse(null, 'Producto eliminado correctamente');
        } catch (Exception $e) {
            return $this->errorResponse('Error al eliminar el producto', $e->getMessage());
        }
    }

    private function findProduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            throw new Exception('Producto no encontrado');
        }
        return $product;
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