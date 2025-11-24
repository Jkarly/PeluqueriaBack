<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $personas = Persona::when($search, function($query, $search) {
                $query->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('apellidopaterno', 'LIKE', "%{$search}%")
                      ->orWhere('apellidomaterno', 'LIKE', "%{$search}%")
                      ->orWhere('ci', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(7);

        return response()->json([
            'success' => true,
            'data' => $personas
        ]);
    }

    public function crear()
    {
        // Método para datos adicionales si se necesitan en el futuro
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'ci' => 'required|string|min:3|unique:personas,ci',
            'nombre' => 'required|string|min:3',
            'apellidopaterno' => 'required|string|min:3',
            'apellidomaterno' => 'required|string|min:3',
            'telefono' => 'nullable|string|min:6',
            'estado' => 'required|boolean',
        ]);

        $persona = Persona::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Persona registrada correctamente',
            'data' => $persona
        ], 201);
    }

    public function editar($id)
    {
        $persona = Persona::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'persona' => $persona
            ]
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $persona = Persona::findOrFail($id);

        $request->validate([
            'ci' => 'required|string|min:3|unique:personas,ci,' . $id,
            'nombre' => 'required|string|min:3',
            'apellidopaterno' => 'required|string|min:3',
            'apellidomaterno' => 'required|string|min:3',
            'telefono' => 'nullable|string|min:6',
            'estado' => 'required|in:0,1',
        ]);

        $data = $request->all();
        $data['estado'] = $request->estado == "1" ? 1 : 0;

        $persona->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Persona actualizada correctamente',
            'data' => $persona
        ]);
    }

    public function eliminar($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();

        return response()->json([
            'success' => true,
            'message' => 'Persona eliminada correctamente'
        ]);
    }

    // Método para obtener personas activas (para selects, etc.)
    public function activos()
    {
        $personas = Persona::where('estado', 1)
            ->orderBy('nombre')
            ->get(['id', 'ci', 'nombre', 'apellidopaterno', 'apellidomaterno']);

        return response()->json([
            'success' => true,
            'data' => $personas
        ]);
    }
}
