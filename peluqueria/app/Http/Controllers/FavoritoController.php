<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorito;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FavoritoController extends Controller
{
    public function index(Request $request)
    {
        try {
            $usuario = Auth::user();
            
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $search = trim($request->input('search', ''));
            $page = $request->input('page', 1);

            $query = Favorito::with(['servicio.categoria'])
                ->where('idusuario', $usuario->id)
                ->where('estado', true);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('servicio', function ($p) use ($search) {
                        $p->where('nombre', 'like', "%$search%")
                          ->orWhere('descripcion', 'like', "%$search%");
                    });
                });
            }

            $favoritos = $query->orderBy('created_at', 'desc')->paginate(10, ['*'], 'page', $page);

            return response()->json([
                'success' => true,
                'data' => $favoritos
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener favoritos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Ocurrió un error al obtener los favoritos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function crear()
    {
        try {
            $usuario = Auth::user();
            
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            // Obtener servicios disponibles
            $servicios = Servicio::where('estado', 1)
                ->with('categoria')
                ->orderBy('nombre')
                ->get()
                ->map(function ($servicio) use ($usuario) {
                    // Verificar si ya es favorito
                    $esFavorito = Favorito::where('idusuario', $usuario->id)
                        ->where('idservicio', $servicio->id)
                        ->where('estado', true)
                        ->exists();

                    return [
                        'id' => $servicio->id,
                        'nombre' => $servicio->nombre,
                        'precio' => $servicio->precio,
                        'duracionmin' => $servicio->duracionmin,
                        'descripcion' => $servicio->descripcion,
                        'imagen' => $servicio->imagen,
                        'categoria' => $servicio->categoria ? [
                            'id' => $servicio->categoria->id,
                            'nombre' => $servicio->categoria->nombre
                        ] : null,
                        'es_favorito' => $esFavorito
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => [
                    'servicios' => $servicios
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error en crear favoritos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener datos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'idservicio' => 'required|exists:servicios,id',
            'estado' => 'required|boolean'
        ]);

        try {
            $usuario = Auth::user();
            
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            // Verificar que el servicio existe y está activo
            $servicio = Servicio::where('id', $request->idservicio)
                ->where('estado', 1)
                ->first();

            if (!$servicio) {
                return response()->json([
                    'success' => false,
                    'error' => 'El servicio no existe o no está disponible'
                ], 422);
            }

            // Buscar si ya existe un registro
            $favorito = Favorito::where('idusuario', $usuario->id)
                ->where('idservicio', $request->idservicio)
                ->first();

            if ($favorito) {
                // Actualizar estado
                $favorito->update(['estado' => $request->estado]);
                $mensaje = $request->estado ? 'Servicio agregado a favoritos' : 'Servicio removido de favoritos';
            } else {
                // Crear nuevo registro
                $favorito = Favorito::create([
                    'idusuario' => $usuario->id,
                    'idservicio' => $request->idservicio,
                    'estado' => $request->estado
                ]);
                $mensaje = 'Servicio agregado a favoritos';
            }

            // Cargar relaciones para la respuesta
            $favorito->load(['servicio.categoria']);

            Log::info('Favorito actualizado', [
                'usuario_id' => $usuario->id,
                'servicio_id' => $request->idservicio,
                'estado' => $request->estado
            ]);

            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'data' => $favorito
            ]);

        } catch (\Exception $e) {
            Log::error('Error al guardar favorito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al guardar el favorito: ' . $e->getMessage()
            ], 500);
        }
    }

    public function editar($id)
    {
        try {
            $usuario = Auth::user();
            
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $favorito = Favorito::with(['servicio.categoria'])
                ->where('id', $id)
                ->where('idusuario', $usuario->id)
                ->firstOrFail();

            // Obtener servicios disponibles
            $servicios = Servicio::where('estado', 1)
                ->with('categoria')
                ->orderBy('nombre')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'favorito' => $favorito,
                    'servicios' => $servicios
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener favorito para editar: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al cargar el favorito: ' . $e->getMessage()
            ], 500);
        }
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|boolean'
        ]);

        try {
            $usuario = Auth::user();
            
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $favorito = Favorito::where('id', $id)
                ->where('idusuario', $usuario->id)
                ->firstOrFail();

            $favorito->update(['estado' => $request->estado]);

            $mensaje = $request->estado ? 'Favorito activado' : 'Favorito desactivado';

            // Cargar relaciones actualizadas
            $favorito->load(['servicio.categoria']);

            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'data' => $favorito
            ]);

        } catch (\Exception $e) {
            Log::error('Error al actualizar favorito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar el favorito: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminar($id)
    {
        try {
            $usuario = Auth::user();
            
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $favorito = Favorito::where('id', $id)
                ->where('idusuario', $usuario->id)
                ->firstOrFail();

            $favorito->delete();

            return response()->json([
                'success' => true,
                'message' => 'Favorito eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al eliminar favorito: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar el favorito: ' . $e->getMessage()
            ], 500);
        }
    }

    // Método para obtener favoritos del usuario actual
    public function misFavoritos()
    {
        try {
            $usuario = Auth::user();
            
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $favoritos = Favorito::with(['servicio.categoria'])
                ->where('idusuario', $usuario->id)
                ->where('estado', true)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $favoritos
            ]);

        } catch (\Exception $e) {
            Log::error('Error al obtener mis favoritos: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error al obtener los favoritos: ' . $e->getMessage()
            ], 500);
        }
    }
}