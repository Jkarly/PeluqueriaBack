<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Producto;
use App\Models\ProductoUtilizado;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\DB;

class ProductoUtilizadoController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = trim($request->input('search', ''));
            $page = $request->input('page', 1);

            $query = ProductoUtilizado::with([
                'cita',
                'cita.cliente.persona',
                'cita.empleado.persona',
                'producto'
            ]);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    // Buscar por nombre de producto
                    $q->whereHas('producto', function ($p) use ($search) {
                        $p->where('nombre', 'like', "%$search%");
                    });
                    
                    // Buscar por ID de cita
                    $q->orWhereHas('cita', function ($c) use ($search) {
                        $c->where('id', 'like', "%$search%");
                    });
                    
                    // Buscar por observaciones
                    $q->orWhere('observaciones', 'like', "%$search%");
                    
                    // Buscar por nombre de cliente
                    $q->orWhereHas('cita.cliente.persona', function ($persona) use ($search) {
                        $persona->where('nombre', 'like', "%$search%")
                            ->orWhere('apellidopaterno', 'like', "%$search%")
                            ->orWhere('apellidomaterno', 'like', "%$search%");
                    });
                });
            }

            $productosUtilizados = $query->orderBy('created_at', 'desc')->paginate(10, ['*'], 'page', $page);

            return response()->json([
                'success' => true,
                'data' => $productosUtilizados
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener productos utilizados: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Ocurrió un error al obtener los datos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function crear()
    {
        try {
            // Obtener citas con estado "aceptado" con relaciones corregidas
            $citas = Cita::where('estado', 'aceptado') 
                    ->with([
                        'cliente.persona:id,ci,nombre,apellidopaterno,apellidomaterno',
                        'empleado.persona:id,ci,nombre,apellidopaterno,apellidomaterno'
                    ])
                    ->orderBy('id', 'desc')
                    ->get()
                    ->map(function ($cita) {
                        // mostrar nombre del cliente desde la relación persona
                        $nombreCliente = 'Cliente no disponible';
                        if ($cita->cliente && $cita->cliente->persona) {
                            $persona = $cita->cliente->persona;
                            $nombreCliente = trim($persona->nombre . ' ' . 
                                                ($persona->apellidopaterno ?? '') . ' ' . 
                                                ($persona->apellidomaterno ?? ''));
                        }

                        // mostrar nombre del empleado desde la relación persona
                        $nombreEmpleado = 'Empleado no disponible';
                        if ($cita->empleado && $cita->empleado->persona) {
                            $persona = $cita->empleado->persona;
                            $nombreEmpleado = trim($persona->nombre . ' ' . 
                                                 ($persona->apellidopaterno ?? '') . ' ' . 
                                                 ($persona->apellidomaterno ?? ''));
                        }

                        return [
                            'id' => $cita->id,
                            'fechahorainicio' => $cita->fechahorainicio,
                            'estado' => $cita->estado,
                            'cliente' => $cita->cliente ? [
                                'id' => $cita->cliente->id,
                                'nombre' => $nombreCliente,
                                'persona' => $cita->cliente->persona ? [
                                    'id' => $cita->cliente->persona->id,
                                    'nombre' => $cita->cliente->persona->nombre,
                                    'apellidopaterno' => $cita->cliente->persona->apellidopaterno,
                                    'apellidomaterno' => $cita->cliente->persona->apellidomaterno,
                                    'ci' => $cita->cliente->persona->ci
                                ] : null
                            ] : null,
                            'empleado' => $cita->empleado ? [
                                'id' => $cita->empleado->id,
                                'nombre' => $nombreEmpleado,
                                'persona' => $cita->empleado->persona ? [
                                    'id' => $cita->empleado->persona->id,
                                    'nombre' => $cita->empleado->persona->nombre,
                                    'apellidopaterno' => $cita->empleado->persona->apellidopaterno,
                                    'apellidomaterno' => $cita->empleado->persona->apellidomaterno,
                                    'ci' => $cita->empleado->persona->ci
                                ] : null
                            ] : null
                        ];
                    });
            
            // Obtener productos activos con stock
            $productos = Producto::where('estado', 1)
                               ->where('stock', '>', 0)
                               ->orderBy('nombre')
                               ->get()
                               ->map(function ($producto) {
                                   return [
                                       'id' => $producto->id,
                                       'nombre' => $producto->nombre,
                                       'descripcion' => $producto->descripcion,
                                       'preciounitario' => $producto->preciounitario,
                                       'stock' => $producto->stock,
                                       'estado' => $producto->estado
                                   ];
                               });

            Log::info('Datos cargados para crear producto utilizado', [
                'citas_count' => $citas->count(),
                'productos_count' => $productos->count()
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'citas' => $citas,
                    'productos' => $productos
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error en crear productos utilizados: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener datos para crear: ' . $e->getMessage()
            ], 500);
        }
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'estado' => 'required|boolean',
            'observaciones' => 'nullable|string|max:500',
            'idcita' => 'required|exists:citas,id',
            'idproducto' => 'required|exists:productos,id'
        ]);

        DB::beginTransaction();

        try {
            // Verificar que la cita existe y está en estado "aceptado"
            $cita = Cita::where('id', $request->idcita)
                    ->where('estado', 'aceptado')
                    ->first();
            
            if (!$cita) {
                return response()->json([
                    'success' => false,
                    'error' => 'La cita seleccionada no existe o no está en estado "aceptado"'
                ], 422);
            }

            // Verificar stock disponible
            $producto = Producto::where('id', $request->idproducto)
                            ->where('estado', 1)
                            ->first();
            
            if (!$producto) {
                return response()->json([
                    'success' => false,
                    'error' => 'El producto seleccionado no existe o no está activo'
                ], 422);
            }

            if ($producto->stock < $request->cantidad) {
                return response()->json([
                    'success' => false,
                    'error' => 'Stock insuficiente. Stock disponible: ' . $producto->stock
                ], 422);
            }

            // Crear el registro de producto utilizado
            $productoUtilizado = ProductoUtilizado::create([
                'cantidad' => $request->cantidad,
                'estado' => $request->estado,
                'observaciones' => $request->observaciones,
                'idcita' => $request->idcita,
                'idproducto' => $request->idproducto
            ]);

            // Actualizar stock del producto
            $producto->decrement('stock', $request->cantidad);

            DB::commit();

            // Cargar relaciones para la respuesta
            $productoUtilizado->load(['cita.cliente.persona', 'cita.empleado.persona', 'producto']);

            Log::info('Producto utilizado creado exitosamente', [
                'id' => $productoUtilizado->id,
                'cita_id' => $request->idcita,
                'producto_id' => $request->idproducto,
                'cantidad' => $request->cantidad
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Producto utilizado registrado correctamente',
                'data' => $productoUtilizado
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al registrar producto utilizado: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Error al registrar el producto utilizado: ' . $e->getMessage()
            ], 500);
        }
    }

    // Obtener datos para editar - API
    public function editar($id)
    {
        try {
            $productoUtilizado = ProductoUtilizado::with([
                'cita.cliente.persona', 
                'cita.empleado.persona', 
                'producto'
            ])->findOrFail($id);
            
            // Usar las mismas relaciones corregidas
            $citas = Cita::where('estado', 'aceptado')
                        ->with([
                            'cliente.persona:id,ci,nombre,apellidopaterno,apellidomaterno',
                            'empleado.persona:id,ci,nombre,apellidopaterno,apellidomaterno'
                        ])
                        ->orderBy('id', 'desc')
                        ->get();
            
            $productos = Producto::where('estado', 1)
                           ->orderBy('nombre')
                           ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'productoUtilizado' => $productoUtilizado,
                    'citas' => $citas,
                    'productos' => $productos
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener producto utilizado para editar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al cargar el registro: ' . $e->getMessage()
            ], 500);
        }
    }

    // Actualizar producto utilizado - API
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'estado' => 'required|boolean',
            'observaciones' => 'nullable|string|max:500',
            'idcita' => 'required|exists:citas,id',
            'idproducto' => 'required|exists:productos,id'
        ]);

        DB::beginTransaction();

        try {
            $productoUtilizado = ProductoUtilizado::with('producto')->findOrFail($id);

            // Verificar que la nueva cita esté en estado "aceptado"
            $cita = Cita::where('id', $request->idcita)
                    ->where('estado', 'aceptado')
                    ->first();
            
            if (!$cita) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'error' => 'La cita seleccionada no existe o no está en estado "aceptado"'
                ], 422);
            }

            // Lógica para manejar cambios en cantidad y producto
            $cantidadAnterior = $productoUtilizado->cantidad;
            $productoAnterior = $productoUtilizado->producto;
            $nuevaCantidad = $request->cantidad;
            $nuevoProductoId = $request->idproducto;

            // Si cambió el producto
            if ($productoAnterior->id != $nuevoProductoId) {
                // Restaurar stock del producto anterior
                $productoAnterior->increment('stock', $cantidadAnterior);
                
                // Verificar stock del nuevo producto
                $nuevoProducto = Producto::findOrFail($nuevoProductoId);
                if ($nuevoProducto->stock < $nuevaCantidad) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'error' => 'Stock insuficiente en el nuevo producto. Stock disponible: ' . $nuevoProducto->stock
                    ], 422);
                }
                
                // Actualizar stock del nuevo producto
                $nuevoProducto->decrement('stock', $nuevaCantidad);
            } else {
                // Mismo producto, solo cambió la cantidad
                $diferencia = $nuevaCantidad - $cantidadAnterior;
                if ($diferencia > 0) {
                    // Aumentó la cantidad, verificar stock
                    if ($productoAnterior->stock < $diferencia) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'error' => 'Stock insuficiente para aumentar la cantidad. Stock disponible: ' . $productoAnterior->stock
                        ], 422);
                    }
                    $productoAnterior->decrement('stock', $diferencia);
                } elseif ($diferencia < 0) {
                    // Disminuyó la cantidad, restaurar stock
                    $productoAnterior->increment('stock', abs($diferencia));
                }
            }

            // Actualizar el registro
            $productoUtilizado->update($request->all());

            DB::commit();

            // Cargar relaciones actualizadas
            $productoUtilizado->load(['cita.cliente.persona', 'cita.empleado.persona', 'producto']);

            return response()->json([
                'success' => true,
                'message' => 'Producto utilizado actualizado correctamente',
                'data' => $productoUtilizado
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar producto utilizado: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar el producto utilizado: ' . $e->getMessage()
            ], 500);
        }
    }

    // Eliminar producto utilizado - API
    public function eliminar($id)
    {
        DB::beginTransaction();

        try {
            $productoUtilizado = ProductoUtilizado::with('producto')->findOrFail($id);

            // Restaurar stock al eliminar
            $productoUtilizado->producto->increment('stock', $productoUtilizado->cantidad);

            $productoUtilizado->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Producto utilizado eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al eliminar producto utilizado: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar el producto utilizado: ' . $e->getMessage()
            ], 500);
        }
    }
}