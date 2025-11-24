<?php

namespace App\Http\Controllers;

use App\Models\Promocion;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromocionController extends Controller
{
    // Listado de promociones con búsqueda - API
    public function index(Request $request)
    {
        $search = $request->input('search');

        $promociones = Promocion::with('servicio')
            ->when($search, function ($query, $search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                      ->orWhere('descripcion', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $promociones
        ]);
    }

    // Obtener datos para crear - API
    public function crear()
    {
        $servicios = Servicio::where('estado', 1)->orderBy('nombre')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'servicios' => $servicios
            ]
        ]);
    }

    // Guardar nueva promoción - API
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descripcion' => 'nullable|string',
            'descuento' => 'required|numeric|min:0',
            'estado' => 'required|boolean',
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date|after_or_equal:fechainicio',
            'idservicio' => 'required|exists:servicios,id'
        ]);

        try {
            $data = $request->all();

            if ($request->hasFile('imagen')) {
                $path = $request->file('imagen')->store('images/promociones', 'public');
                $data['imagen'] = basename($path);
            } else {
                $data['imagen'] = null;
            }

            $promocion = Promocion::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Promoción registrada correctamente',
                'data' => $promocion->load('servicio')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al crear la promoción: ' . $e->getMessage()
            ], 500);
        }
    }

    // Obtener datos para editar - API
    public function editar($id)
    {
        $promocion = Promocion::with('servicio')->findOrFail($id);
        $servicios = Servicio::where('estado', 1)->orderBy('nombre')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'promocion' => $promocion,
                'servicios' => $servicios
            ]
        ]);
    }

    // Actualizar promoción - API
    public function actualizar(Request $request, $id)
    {
        $promocion = Promocion::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descripcion' => 'nullable|string',
            'descuento' => 'required|numeric|min:0',
            'estado' => 'required|boolean',
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date|after_or_equal:fechainicio',
            'idservicio' => 'required|exists:servicios,id'
        ]);

        try {
            $data = $request->all();

            if ($request->hasFile('imagen')) {
                if ($promocion->imagen && Storage::disk('public')->exists('images/promociones/' . $promocion->imagen)) {
                    Storage::disk('public')->delete('images/promociones/' . $promocion->imagen);
                }

                $path = $request->file('imagen')->store('images/promociones', 'public');
                $data['imagen'] = basename($path);
            } else {
                $data['imagen'] = $promocion->imagen;
            }

            $promocion->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Promoción actualizada correctamente',
                'data' => $promocion->load('servicio')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al actualizar la promoción: ' . $e->getMessage()
            ], 500);
        }
    }

    // Eliminar promoción - API
    public function eliminar($id)
    {
        try {
            $promocion = Promocion::findOrFail($id);

            if ($promocion->imagen && Storage::disk('public')->exists('images/promociones/' . $promocion->imagen)) {
                Storage::disk('public')->delete('images/promociones/' . $promocion->imagen);
            }

            $promocion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Promoción eliminada correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error al eliminar la promoción: ' . $e->getMessage()
            ], 500);
        }
    }

    // Método para servir imágenes
    public function obtenerImagen($filename)
    {
        $path = storage_path('app/public/images/promociones/' . $filename);

        if (!Storage::disk('public')->exists('images/promociones/' . $filename)) {
            abort(404);
        }

        return response()->file($path);
    }

    
}
