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
            return response()->json($products, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al obtener productos', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }

            return response()->json($product, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al obtener el producto', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());
            return response()->json($product, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al crear el producto', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }

            $request->validate([
                'name' => 'required|string|max:255|unique:products,name,' . $id,
                'price' => 'required|numeric|min:0',
            ]);

            $product->update($request->validated());

            return response()->json(['message' => 'Producto actualizado', 'product' => $product], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al actualizar el producto', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['error' => 'Producto no encontrado'], 404);
            }

            $product->delete();

            return response()->json(['message' => 'Producto eliminado'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al eliminar el producto', 'message' => $e->getMessage()], 500);
        }
    }
}
