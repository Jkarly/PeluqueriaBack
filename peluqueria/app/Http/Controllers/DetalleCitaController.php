<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cita;
use App\Models\Detalle_cita;
use App\Models\Servicio;
use Illuminate\Http\Request;

class DetalleCitaController extends Controller
{
    private $ROL_ADMIN = 1;
    private $ROL_EMPLEADO = 2;
    private $ROL_CLIENTE = 3;

    public function index(Request $request)
    {
        $usuario = Auth::user();

        if (!in_array($usuario->idrol, [$this->ROL_ADMIN, $this->ROL_EMPLEADO])) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        $buscar = $request->input('buscar');
        $estadoCita = $request->input('estado_cita');
        $fechaDesde = $request->input('fecha_desde');
        $fechaHasta = $request->input('fecha_hasta');
        $servicioId = $request->input('servicio_id');
        $empleadoId = $request->input('empleado_id');

        $detalles = Detalle_cita::with(['cita.cliente.persona', 'cita.empleado.persona', 'servicio'])
            ->when($buscar, function ($query) use ($buscar) {
                $query->whereHas('cita.cliente.persona', function ($q) use ($buscar) {
                    $q->where('nombre', 'LIKE', "%{$buscar}%")
                      ->orWhere('apellidopaterno', 'LIKE', "%{$buscar}%");
                });
            })
            ->when($estadoCita, function ($query) use ($estadoCita) {
                $query->whereHas('cita', function ($q) use ($estadoCita) {
                    $q->where('estado', $estadoCita);
                });
            })
            ->when($fechaDesde, function ($query) use ($fechaDesde) {
                $query->whereHas('cita', function ($q) use ($fechaDesde) {
                    $q->where('fechahorainicio', '>=', $fechaDesde);
                });
            })
            ->when($fechaHasta, function ($query) use ($fechaHasta) {
                $query->whereHas('cita', function ($q) use ($fechaHasta) {
                    $q->where('fechahorainicio', '<=', $fechaHasta . ' 23:59:59');
                });
            })
            ->when($servicioId, function ($query) use ($servicioId) {
                $query->where('idservicio', $servicioId);
            })
            ->when($empleadoId, function ($query) use ($empleadoId) {
                $query->whereHas('cita', function ($q) use ($empleadoId) {
                    $q->where('idempleado', $empleadoId);
                });
            })
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $detalles
        ]);
    }

    public function filtros()
    {
        $usuario = Auth::user();

        if (!in_array($usuario->idrol, [$this->ROL_ADMIN, $this->ROL_EMPLEADO])) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        $servicios = Servicio::select('id', 'nombre')->get();
        $empleados = \App\Models\Empleado::with('persona')->get()->map(function($empleado) {
            return [
                'id' => $empleado->id,
                'nombre_completo' => $empleado->persona->nombre . ' ' . $empleado->persona->apellidopaterno
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'servicios' => $servicios,
                'empleados' => $empleados,
                'estados_cita' => [
                    ['value' => 'pendiente', 'label' => 'Pendiente'],
                    ['value' => 'aceptado', 'label' => 'Aceptado'],
                    ['value' => 'rechazado', 'label' => 'Rechazado']
                ]
            ]
        ]);
    }

    public function crear()
    {
        $usuario = Auth::user();

        if (!in_array($usuario->idrol, [$this->ROL_ADMIN, $this->ROL_EMPLEADO])) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        $citas = Cita::with(['cliente.persona'])->get();
        $servicios = Servicio::all();

        return response()->json([
            'success' => true,
            'data' => [
                'citas' => $citas,
                'servicios' => $servicios
            ]
        ]);
    }

    public function guardar(Request $request)
    {
        $usuario = Auth::user();

        if (!in_array($usuario->idrol, [$this->ROL_ADMIN, $this->ROL_EMPLEADO])) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        $request->validate([
            'preciocobrado' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string|max:500',
            'idcita' => 'required|exists:citas,id',
            'idservicio' => 'required|exists:servicios,id',
        ]);

        try {
            $detalle = Detalle_cita::create([
                'estado' => 1, // pagado por defecto (o lo que signifique en tu lógica)
                'preciocobrado' => $request->preciocobrado,
                'observaciones' => $request->observaciones,
                'idcita' => $request->idcita,
                'idservicio' => $request->idservicio,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Detalle de cita creado correctamente',
                'data' => $detalle->load(['cita.cliente.persona', 'servicio'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al crear el detalle: ' . $e->getMessage()
            ], 500);
        }
    }

    public function editar($id)
    {
        $usuario = Auth::user();

        if (!in_array($usuario->idrol, [$this->ROL_ADMIN, $this->ROL_EMPLEADO])) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        $detalle = Detalle_cita::with(['cita.cliente.persona', 'servicio'])->findOrFail($id);
        $citas = Cita::with(['cliente.persona'])->get();
        $servicios = Servicio::all();

        return response()->json([
            'success' => true,
            'data' => [
                'detalle' => $detalle,
                'citas' => $citas,
                'servicios' => $servicios
            ]
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $usuario = Auth::user();

        if (!in_array($usuario->idrol, [$this->ROL_ADMIN, $this->ROL_EMPLEADO])) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        $request->validate([
            'estado' => 'required|in:0,1',   // aquí aceptamos 0 o 1
            'preciocobrado' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string|max:500',
            'idcita' => 'required|exists:citas,id',
            'idservicio' => 'required|exists:servicios,id',
        ]);

        try {
            $detalle = Detalle_cita::findOrFail($id);
            $detalle->update([
                'estado' => $request->estado,
                'preciocobrado' => $request->preciocobrado,
                'observaciones' => $request->observaciones,
                'idcita' => $request->idcita,
                'idservicio' => $request->idservicio,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Detalle de cita actualizado correctamente',
                'data' => $detalle->load(['cita.cliente.persona', 'servicio'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar el detalle: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminar($id)
    {
        $usuario = Auth::user();

        if (!in_array($usuario->idrol, [$this->ROL_ADMIN, $this->ROL_EMPLEADO])) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        try {
            $detalle = Detalle_cita::findOrFail($id);
            $detalle->delete();

            return response()->json([
                'success' => true,
                'message' => 'Detalle de cita eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar el detalle: ' . $e->getMessage()
            ], 500);
        }
    }

    public function historialCliente()
    {
        $usuario = Auth::user();

        $detalles = Detalle_cita::with([
            'cita.cliente.persona',
            'cita.empleado.persona',
            'servicio'
        ])
        ->whereHas('cita.cliente', function($query) use ($usuario) {
            $query->where('idpersona', $usuario->idpersona);
        })
        ->orderBy('id', 'DESC')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $detalles
        ]);
    }
}
