<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Empleado_Especialidad;
use App\Models\Especialidad;
use Illuminate\Http\Request;

class EmpleadoEspecialidadController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->input('search');

        $empleadoEspecialidades = Empleado_Especialidad::with(['empleado.persona', 'especialidad'])
            ->when($search, function($query, $search) {
                $query->whereHas('empleado.persona', function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('apellidopaterno', 'LIKE', "%{$search}%")
                      ->orWhere('apellidomaterno', 'LIKE', "%{$search}%");
                })->orWhereHas('especialidad', function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(7);

        return response()->json([
            'success' => true,
            'data' => $empleadoEspecialidades
        ]);
    }

    public function crear()
    {
        $empleados = Empleado::with('persona')
            ->get()
            ->map(function($empleado) {
                return [
                    'id' => $empleado->id,
                    'nombre_completo' => $empleado->persona ? 
                        $empleado->persona->nombre . ' ' . $empleado->persona->apellidopaterno . ' ' . $empleado->persona->apellidomaterno : 
                        'Sin persona'
                ];
            });

        $especialidades = Especialidad::where('estado', 1)
            ->get(['id', 'nombre']);

        return response()->json([
            'success' => true,
            'data' => [
                'empleados' => $empleados,
                'especialidades' => $especialidades
            ]
        ]);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'id_empleado' => 'required|exists:empleados,id',
            'id_especialidad' => 'required|exists:especialidads,id',
        ]);

        // Verificar si ya existe la combinación
        $existe = Empleado_Especialidad::where('id_empleado', $request->id_empleado)
            ->where('id_especialidad', $request->id_especialidad)
            ->exists();

        if ($existe) {
            return response()->json([
                'success' => false,
                'message' => 'Esta combinación de empleado y especialidad ya existe'
            ], 422);
        }

        $empleadoEspecialidad = Empleado_Especialidad::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Especialidad asignada al empleado correctamente',
            'data' => $empleadoEspecialidad
        ], 201);
    }

    public function editar($id)
    {
        $empleadoEspecialidad = Empleado_Especialidad::with(['empleado.persona', 'especialidad'])->findOrFail($id);
        
        $empleados = Empleado::with('persona')
            ->get()
            ->map(function($empleado) {
                return [
                    'id' => $empleado->id,
                    'nombre_completo' => $empleado->persona ? 
                        $empleado->persona->nombre . ' ' . $empleado->persona->apellidopaterno . ' ' . $empleado->persona->apellidomaterno : 
                        'Sin persona'
                ];
            });

        $especialidades = Especialidad::where('estado', 1)
            ->get(['id', 'nombre']);

        return response()->json([
            'success' => true,
            'data' => [
                'empleadoEspecialidad' => $empleadoEspecialidad,
                'empleados' => $empleados,
                'especialidades' => $especialidades
            ]
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $empleadoEspecialidad = Empleado_Especialidad::findOrFail($id);

        $request->validate([
            'id_empleado' => 'required|exists:empleados,id',
            'id_especialidad' => 'required|exists:especialidads,id',
        ]);

        // Verificar si ya existe la combinación (excluyendo el actual)
        $existe = Empleado_Especialidad::where('id_empleado', $request->id_empleado)
            ->where('id_especialidad', $request->id_especialidad)
            ->where('id', '!=', $id)
            ->exists();

        if ($existe) {
            return response()->json([
                'success' => false,
                'message' => 'Esta combinación de empleado y especialidad ya existe'
            ], 422);
        }

        $empleadoEspecialidad->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Especialidad del empleado actualizada correctamente',
            'data' => $empleadoEspecialidad
        ]);
    }

    public function eliminar($id)
    {
        $empleadoEspecialidad = Empleado_Especialidad::findOrFail($id);
        $empleadoEspecialidad->delete();

        return response()->json([
            'success' => true,
            'message' => 'Especialidad del empleado eliminada correctamente'
        ]);
    }
}
