<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->input('search');

        $especialidades = Especialidad::when($search, fn($q) => $q->where('nombre', 'LIKE', "%{$search}%"))
            ->orderBy('id', 'desc')
            ->paginate(7);

        return response()->json([
            'success' => true,
            'data' => $especialidades
        ]);
    }

    public function crear()
    {
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:3|unique:especialidads,nombre', // CAMBIADO: especialidades -> especialidads
            'estado' => 'required|boolean',
        ]);

        $especialidad = Especialidad::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Especialidad registrada correctamente',
            'data' => $especialidad
        ], 201);
    }

    public function editar($id)
    {
        $especialidad = Especialidad::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'especialidad' => $especialidad
            ]
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $especialidad = Especialidad::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|min:3|unique:especialidads,nombre,' . $id, // CAMBIADO: especialidades -> especialidads
            'estado' => 'required|in:0,1',
        ]);

        $data = $request->all();
        $data['estado'] = $request->estado == "1" ? 1 : 0;

        $especialidad->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Especialidad actualizada correctamente',
            'data' => $especialidad
        ]);
    }

    public function eliminar($id)
    {
        $especialidad = Especialidad::findOrFail($id);
        $especialidad->delete();

        return response()->json([
            'success' => true,
            'message' => 'Especialidad eliminada correctamente'
        ]);
    }

    public function activos()
    {
        $especialidades = Especialidad::where('estado', 1)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return response()->json([
            'success' => true,
            'data' => $especialidades
        ]);
    }
}
