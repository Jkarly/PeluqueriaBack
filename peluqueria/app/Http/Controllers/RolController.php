<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    // Listado de roles
    public function index(Request $request)
    {
        $search = $request->input('search');

        $roles = Rol::when($search, fn($q) => $q->where('nombre', 'LIKE', "%{$search}%"))
            ->orderBy('id', 'desc')
            ->paginate(7);

        return response()->json([
            'success' => true,
            'data' => $roles
        ]);
    }

    public function crear()
    {
        // Misma estructura que servicioController->crear()
        return response()->json([
            'success' => true,
            'data' => [] // Si necesitas datos adicionales como en servicios
        ]);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:3',
            'descripcion' => 'nullable|string|min:3',
            'estado' => 'required|boolean',
        ]);

        $rol = Rol::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Rol registrado correctamente',
            'data' => $rol
        ], 201);
    }

    public function editar($id)
    {
        $rol = Rol::findOrFail($id);
        
        // Misma estructura que servicioController->editar()
        return response()->json([
            'success' => true,
            'data' => [
                'rol' => $rol
            ]
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|min:3',
            'descripcion' => 'nullable|string|min:3',
            'estado' => 'required|in:0,1',
        ]);

        $data = $request->all();
        $data['estado'] = $request->estado == "1" ? 1 : 0;

        $rol->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Rol actualizado correctamente',
            'data' => $rol
        ]);
    }

    public function eliminar($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rol eliminado correctamente'
        ]);
    }
}
