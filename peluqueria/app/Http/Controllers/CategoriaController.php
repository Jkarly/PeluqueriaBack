<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categorias = Categoria::query()
            ->when($search, function ($q) use ($search) {
                $lower = strtolower($search);
                $q->whereRaw('LOWER(nombre) LIKE ?', ["%{$lower}%"])
                ->orWhereRaw('LOWER(descripcion) LIKE ?', ["%{$lower}%"]);
            })
            ->orderByDesc('id')
            ->get();

        return response()->json(['success' => true, 'data' => $categorias]);
    }


    public function guardar(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|min:3|max:100',
            'estado' => 'required|boolean',
            'descripcion' => 'nullable|string|max:500',
        ]);

        $categoria = Categoria::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Categoría registrada correctamente',
            'data' => $categoria
        ], 201);
    }

    public function mostrar($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['success' => false, 'message' => 'Categoría no encontrada'], 404);
        }

        return response()->json(['success' => true, 'data' => $categoria]);
    }

    public function actualizar(Request $request, $id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json(['success' => false, 'message' => 'Categoría no encontrada'], 404);
        }

        $data = $request->validate([
            'nombre' => 'required|string|min:3|max:100',
            'estado' => 'required|boolean',
            'descripcion' => 'nullable|string|max:500',
        ]);

        $categoria->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Categoría actualizada correctamente',
            'data' => $categoria
        ]);
    }

    public function eliminar($id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json(['success' => false, 'message' => 'Categoría no encontrada'], 404);
        }

        if ($categoria->servicios()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar la categoría porque tiene servicios asociados'
            ], 422);
        }

        $categoria->delete();

        return response()->json(['success' => true, 'message' => 'Categoría eliminada correctamente']);
    }
}
?>