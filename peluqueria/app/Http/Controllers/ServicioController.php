<?php
namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ServicioController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $servicios = Servicio::with('categoria')
            ->when($search, function ($q) use ($search) {
                $q->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($search) . '%']);
            })
            ->orderBy('id', 'desc')
            ->paginate(7);

        return response()->json([
            'success' => true,
            'data' => $servicios
        ]);
    }


    public function crear()
    {
        $categorias = Categoria::select('id', 'nombre')->get();
        return response()->json([
            'success' => true,
            'data' => $categorias
        ]);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:3',
            'duracionmin' => 'nullable|numeric|min:0',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|boolean',
            'descripcion' => 'nullable|string|min:3',
            'idcategoria' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images/servicio', 'public');
            $data['imagen'] = basename($path);
        } else {
            $data['imagen'] = null;
        }

        $servicio = Servicio::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Servicio registrado correctamente',
            'data' => $servicio
        ], 201);
    }

    public function editar($id)
    {
        $servicio = Servicio::with('categoria')->findOrFail($id);
        $categorias = Categoria::orderBy('nombre')->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'servicio' => $servicio,
                'categorias' => $categorias
            ]
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $servicio = Servicio::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|min:3',
            'duracionmin' => 'nullable|numeric|min:0',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|in:0,1',
            'idcategoria' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
            'descripcion' => 'nullable|string|min:3',
        ]);

        $data = $request->all();
        $data['estado'] = $request->estado == "1" ? 1 : 0;

        if ($request->hasFile('imagen')) {
            if ($servicio->imagen && Storage::disk('public')->exists('images/servicio/'.$servicio->imagen)) {
                Storage::disk('public')->delete('images/servicio/'.$servicio->imagen);
            }
            $path = $request->file('imagen')->store('images/servicio', 'public');
            $data['imagen'] = basename($path);
        }

        $servicio->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Servicio actualizado correctamente',
            'data' => $servicio
        ]);
    }

    public function catalogo(Request $request)
    {
        $search = $request->input('search');
        $categoriaId = $request->input('categoria');
        $orden = $request->input('orden', 'nombre');

        $categorias = Categoria::withCount(['servicios' => fn($q) => $q->where('estado', 1)])
            ->orderBy('nombre')->get();

        $servicios = Servicio::with('categoria')
            ->where('estado', 1)
            ->when($search, function($query, $search) {
                $words = explode(' ', strtolower($search));
                foreach ($words as $word) {
                    $query->whereRaw('LOWER(nombre) LIKE ?', ["%{$word}%"]);
                }
            })
            ->when($categoriaId, fn($q) => $q->where('idcategoria', $categoriaId))
            ->when($orden, function($q) use ($orden) {
                if ($orden === 'desc') $q->orderBy('precio', 'desc');
                elseif ($orden === 'asc') $q->orderBy('precio', 'asc');
                else $q->orderBy('nombre');
            })
            ->paginate(8);

        return response()->json([
            'success' => true,
            'data' => [
                'servicios' => $servicios,
                'categorias' => $categorias
            ]
        ]);
    }

    // ------------------ Carrito ------------------ //

    public function carritoAgregar(Request $request)
    {
        $request->validate([
            'idservicio' => 'required|exists:servicios,id',
        ]);

        // Verificar que el servicio esté disponible
        $servicio = Servicio::find($request->idservicio);
        if (!$servicio || !$servicio->estado) {
            return response()->json([
                'success' => false,
                'message' => 'El servicio no está disponible'
            ], 400);
        }

        $carrito = Session::get('carrito', []);

        if (!in_array($request->idservicio, $carrito)) {
            $carrito[] = $request->idservicio;
            Session::put('carrito', $carrito);
            
            // Guardar la sesión inmediatamente
            Session::save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Servicio agregado al carrito',
            'data' => [
                'carrito' => $carrito,
                'count' => count($carrito)
            ]
        ]);
    }

    public function carritoVer()
    {
        $carritoIds = Session::get('carrito', []);
        $servicios = Servicio::with('categoria')->whereIn('id', $carritoIds)->get();

        return response()->json([
            'success' => true,
            'data' => $servicios
        ]);
    }

    public function carritoEliminar($id)
    {
        $carrito = Session::get('carrito', []);
        $carrito = array_values(array_filter($carrito, fn($item) => $item != $id));
        Session::put('carrito', $carrito);
        Session::save();

        return response()->json([
            'success' => true,
            'message' => 'Servicio eliminado del carrito',
            'data' => [
                'carrito' => $carrito,
                'count' => count($carrito)
            ]
        ]);
    }

    public function carritoResumen()
    {
        $carritoIds = Session::get('carrito', []);
        $servicios = Servicio::whereIn('id', $carritoIds)->get();

        return response()->json([
            'success' => true,
            'data' => $servicios
        ]);
    }

    // NUEVO MÉTODO: Sincronizar carrito desde React
    public function carritoSincronizar(Request $request)
    {
        $request->validate([
            'carrito' => 'required|array',
            'carrito.*' => 'integer|exists:servicios,id'
        ]);

        $carrito = $request->carrito;
        
        // Filtrar solo servicios disponibles
        $serviciosDisponibles = Servicio::whereIn('id', $carrito)
            ->where('estado', 1)
            ->pluck('id')
            ->toArray();

        Session::put('carrito', $serviciosDisponibles);
        Session::save();

        return response()->json([
            'success' => true,
            'message' => 'Carrito sincronizado correctamente',
            'data' => [
                'carrito' => $serviciosDisponibles,
                'count' => count($serviciosDisponibles)
            ]
        ]);
    }

    // NUEVO MÉTODO: Obtener estado del carrito
    public function carritoEstado()
    {
        $carritoIds = Session::get('carrito', []);
        
        return response()->json([
            'success' => true,
            'data' => [
                'carrito' => $carritoIds,
                'count' => count($carritoIds)
            ]
        ]);
    }

    public function categoriasConConteo()
    {
        $categorias = Categoria::withCount(['servicios' => function($query) {
            $query->where('estado', 1); 
        }])->orderBy('nombre')->get();

        return response()->json([
            'success' => true,
            'data' => $categorias
        ]);
    }
}