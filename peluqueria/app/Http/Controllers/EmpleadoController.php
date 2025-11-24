<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Persona;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $empleados = Empleado::with(['persona'])
            ->when($search, function($query, $search) {
                $query->whereHas('persona', function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('apellidopaterno', 'LIKE', "%{$search}%")
                      ->orWhere('apellidomaterno', 'LIKE', "%{$search}%");
                })->orWhere('direccion', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(7);

        return response()->json([
            'success' => true,
            'data' => $empleados
        ]);
    }

    public function crear()
    {
        $personas = Persona::select('id', 'nombre', 'apellidopaterno', 'apellidomaterno')->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'personas' => $personas
            ]
        ]);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'direccion' => 'required|string|max:255',
            'idpersona' => 'required|exists:personas,id|unique:empleados,idpersona',
        ]);

        $empleado = Empleado::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Empleado registrado correctamente',
            'data' => $empleado
        ], 201);
    }

    public function editar($id)
    {
        $empleado = Empleado::with(['persona'])->findOrFail($id);
        $personas = Persona::select('id', 'nombre', 'apellidopaterno', 'apellidomaterno')->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'empleado' => $empleado,
                'personas' => $personas
            ]
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $request->validate([
            'direccion' => 'required|string|max:255',
            'idpersona' => 'required|exists:personas,id|unique:empleados,idpersona,' . $id,
        ]);

        $empleado->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Empleado actualizado correctamente',
            'data' => $empleado
        ]);
    }

    public function eliminar($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return response()->json([
            'success' => true,
            'message' => 'Empleado eliminado correctamente'
        ]);
    }
}