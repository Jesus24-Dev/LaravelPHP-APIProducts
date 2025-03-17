<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Exception;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            return $this->successResponse($categories, 'Categorías obtenidas correctamente');
        } catch (Exception $e) {
            return $this->errorResponse('Error al obtener categorías', $e->getMessage());
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = Category::create($request->validated());
            return $this->successResponse($category, 'Categoría creada correctamente', 201);
        } catch (Exception $e) {
            return $this->errorResponse('Error al crear la categoría', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $category = $this->findCategory($id);
            return $this->successResponse($category, 'Categoría obtenida correctamente');
        } catch (Exception $e) {
            return $this->errorResponse('Error al obtener la categoría', $e->getMessage());
        }
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = $this->findCategory($id);
            $category->update($request->validated());
            return $this->successResponse($category, 'Categoría actualizada correctamente');
        } catch (Exception $e) {
            return $this->errorResponse('Error al actualizar la categoría', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $category = $this->findCategory($id);
            $category->delete();
            return $this->successResponse(null, 'Categoría eliminada correctamente', 204);
        } catch (Exception $e) {
            return $this->errorResponse('Error al eliminar la categoría', $e->getMessage());
        }
    }

    private function findCategory($id)
    {
        $category = Category::find($id);
        if (!$category) {
            throw new Exception('Categoría no encontrada');
        }
        return $category;
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