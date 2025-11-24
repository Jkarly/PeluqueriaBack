<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    // Listado de productos con búsqueda - API
    public function index(Request $request)
    {
        $search = $request->input('search');

        $productos = Producto::when($search, function ($query) use ($search) {
                $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(descripcion) LIKE ?', ['%' . strtolower($search) . '%']);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $productos
        ]);
    }


    // Obtener datos para crear - API
    public function crear()
    {
        // Para productos no necesitamos datos adicionales, pero mantenemos la estructura
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }

    // Guardar nuevo producto - API
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'preciounitario' => 'required|numeric|min:0',
            'costo' => 'nullable|numeric|min:0',
            'estado' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $producto = Producto::create($request->all());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Producto registrado correctamente',
                'data' => $producto
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Error al crear el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    // Obtener datos para editar - API
    public function editar($id)
    {
        $producto = Producto::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'producto' => $producto
            ]
        ]);
    }

    // Actualizar producto - API
    public function actualizar(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'preciounitario' => 'required|numeric|min:0',
            'costo' => 'nullable|numeric|min:0',
            'estado' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $producto->update($request->all());

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado correctamente',
                'data' => $producto
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    // Eliminar producto - API
    public function eliminar($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    // Obtener producto por ID - API
    public function mostrar($id)
    {
        $producto = Producto::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $producto
        ]);
    }
}