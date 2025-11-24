<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $horarios = Horario::with(['empleado.persona'])
            ->when($search, function($query, $search) {
                $query->whereHas('empleado.persona', function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('apellidopaterno', 'LIKE', "%{$search}%")
                      ->orWhere('apellidomaterno', 'LIKE', "%{$search}%");
                })->orWhere('dia_semana', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(7);

        return response()->json([
            'success' => true,
            'data' => $horarios
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

        $diasSemana = [
            ['id' => 'Lunes', 'nombre' => 'Lunes'],
            ['id' => 'Martes', 'nombre' => 'Martes'],
            ['id' => 'Miércoles', 'nombre' => 'Miércoles'],
            ['id' => 'Jueves', 'nombre' => 'Jueves'],
            ['id' => 'Viernes', 'nombre' => 'Viernes'],
            ['id' => 'Sábado', 'nombre' => 'Sábado'],
            ['id' => 'Domingo', 'nombre' => 'Domingo']
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'empleados' => $empleados,
                'dias_semana' => $diasSemana
            ]
        ]);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'dia_semana' => 'required|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'id_empleado' => 'required|exists:empleados,id',
        ]);

        $horario = Horario::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Horario registrado correctamente',
            'data' => $horario
        ], 201);
    }

    public function editar($id)
    {
        $horario = Horario::with(['empleado.persona'])->findOrFail($id);
        
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

        $diasSemana = [
            ['id' => 'Lunes', 'nombre' => 'Lunes'],
            ['id' => 'Martes', 'nombre' => 'Martes'],
            ['id' => 'Miércoles', 'nombre' => 'Miércoles'],
            ['id' => 'Jueves', 'nombre' => 'Jueves'],
            ['id' => 'Viernes', 'nombre' => 'Viernes'],
            ['id' => 'Sábado', 'nombre' => 'Sábado'],
            ['id' => 'Domingo', 'nombre' => 'Domingo']
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'horario' => $horario,
                'empleados' => $empleados,
                'dias_semana' => $diasSemana
            ]
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $horario = Horario::findOrFail($id);

        $request->validate([
            'dia_semana' => 'required|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'id_empleado' => 'required|exists:empleados,id',
        ]);

        $horario->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Horario actualizado correctamente',
            'data' => $horario
        ]);
    }

    public function eliminar($id)
    {
        $horario = Horario::findOrFail($id);
        $horario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Horario eliminado correctamente'
        ]);
    }
}