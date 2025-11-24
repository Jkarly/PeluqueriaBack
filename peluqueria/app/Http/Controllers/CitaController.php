<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Cita;
use App\Models\Detalle_cita;
use App\Models\Empleado;
use App\Models\Cliente;
use App\Models\Rol;
use App\Models\Servicio;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    private $ROL_ADMIN = 1; 
    private $ROL_EMPLEADO = 2; 
    private $ROL_CLIENTE = 3;  
    
    //solo para cualquier usuario que no sean cliente
    public function index(Request $request)
    {
        $usuario = Auth::user();

        if ($usuario->idrol == $this->ROL_CLIENTE || !$usuario->idrol) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        $buscar = $request->input('buscar');

        $citas = Cita::with(['cliente.persona', 'empleado.persona', 'detalles.servicio'])
            ->when($buscar, function ($query) use ($buscar) {
                $query->whereHas('cliente.persona', function ($q) use ($buscar) {
                    $q->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($buscar) . '%'])
                    ->orWhereRaw('LOWER(apellidopaterno) LIKE ?', ['%' . strtolower($buscar) . '%']);
                });
            })
            ->orderBy('fechahorainicio', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $citas
        ]);
    }


    public function editar($id)
    {
        $usuario = Auth::user();

        // Permitir a admin y empleados editar citas
        if ($usuario->idrol == $this->ROL_CLIENTE || !$usuario->idrol) {
            return response()->json(['error' => 'Acceso denegado'], 403);
        }

        $cita = Cita::with(['cliente.persona', 'empleado.persona', 'detalles.servicio'])->findOrFail($id);
        $clientes = Cliente::with('persona')->get();
        $empleados = Empleado::with('persona')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'cita' => $cita,
                'clientes' => $clientes,
                'empleados' => $empleados,
            ]
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $usuario = Auth::user();

        // Permitir a admin Y empleados actualizar citas
        if (!in_array($usuario->idrol, [$this->ROL_ADMIN, $this->ROL_EMPLEADO])) {
            return response()->json([
                'success' => false,
                'error' => 'Solo administradores y empleados pueden actualizar citas'
            ], 403);
        }

        $request->validate([
            'estado' => 'required|string|in:pendiente,aceptado,rechazado',
            'fechahorainicio' => 'required|date',
            'idcliente' => 'required|exists:clientes,id',
            'idempleado' => 'required|exists:empleados,id',
        ]);

        try {
            $cita = Cita::findOrFail($id);
            
            $cita->update([
                'estado' => $request->estado,
                'fechahorainicio' => $request->fechahorainicio,
                'idcliente' => $request->idcliente,
                'idempleado' => $request->idempleado,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cita actualizada correctamente',
                'data' => $cita->load(['cliente.persona', 'empleado.persona'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar la cita: ' . $e->getMessage()
            ], 500);
        }
    }

    //crear
    public function reservar()
    {
        $usuario = Auth::user();

        if (!Rol::where('id', $usuario->idrol)->exists()) {
            return response()->json(['error' => 'Rol no válido'], 403);
        }

        $cliente = Cliente::with('persona')->where('idpersona', $usuario->idpersona)->first();
        if (!$cliente) {
            return response()->json(['error' => 'No se encontró tu perfil de cliente'], 404);
        }

        $empleados = Empleado::with('persona')->get();

        // Obtener servicios del carrito
        $carritoIds = Session::get('carrito', []);
        $serviciosCarrito = Servicio::whereIn('id', $carritoIds)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'idcliente' => $cliente->id,
                'idusuariocreador' => $usuario->id,
                'cliente' => $cliente,
                'empleados' => $empleados,
                'serviciosCarrito' => $serviciosCarrito,
                'carritoCount' => count($carritoIds)
            ]
        ]);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'estado' => 'required|string|in:pendiente,aceptado,rechazado', // Validación corregida
            'fechahorainicio' => 'required|date',
            'idcliente' => 'required|exists:clientes,id',
            'idempleado' => 'required|exists:empleados,id',
        ]);

        $empleado = Empleado::find($request->idempleado);
        $cliente = Cliente::find($request->idcliente);

        if (!$empleado || !$cliente) {
            return response()->json(['error' => 'Cliente o empleado no existe'], 404);
        }

        $cita = Cita::create([
            'estado' => $request->estado,
            'fechahorainicio' => $request->fechahorainicio,
            'idcliente' => $request->idcliente,
            'idempleado' => $request->idempleado,
            'idusuariocreador' => Auth::id(),
        ]);

        // Detalles de cita desde carrito
        $carrito = Session::get('carrito', []);
        $detallesCreados = [];
        
        foreach ($carrito as $idservicio) {
            $servicio = Servicio::find($idservicio);
            if ($servicio) {
                $detalle = Detalle_cita::create([
                    'estado' => 0,
                    'preciocobrado' => $servicio->precio,
                    'observaciones' => null,
                    'idcita' => $cita->id,
                    'idservicio' => $idservicio,
                ]);
                $detallesCreados[] = $detalle;
            }
        }
        
        // Limpiar carrito después de crear la cita
        Session::forget('carrito');

        return response()->json([
            'success' => true,
            'message' => 'Cita creada correctamente con ' . count($detallesCreados) . ' servicios',
            'data' => [
                'cita' => $cita->load('detalles.servicio'),
                'detalles' => $detallesCreados
            ]
        ]);
    }
}