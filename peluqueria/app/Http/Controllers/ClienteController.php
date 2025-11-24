<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Persona;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
   public function index(Request $request)
    {
        $search = $request->input('search');

        $clientes = Cliente::with(['persona'])
            ->when($search, function($query, $search) {
                $query->whereHas('persona', function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('apellidopaterno', 'LIKE', "%{$search}%")
                      ->orWhere('apellidomaterno', 'LIKE', "%{$search}%")
                      ->orWhere('ci', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(7);

        return response()->json([
            'success' => true,
            'data' => $clientes
        ]);
    }

    public function crear()
    {
        $personas = Persona::select('id', 'ci', 'nombre', 'apellidopaterno', 'apellidomaterno')
            ->where('estado', 1)
            ->get();
        
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
            'cliente_habitual' => 'required|boolean',
            'idpersona' => 'required|exists:personas,id',
        ]);

        $cliente = Cliente::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Cliente registrado correctamente',
            'data' => $cliente
        ], 201);
    }

    public function editar($id)
    {
        $cliente = Cliente::with(['persona'])->findOrFail($id);
        $personas = Persona::select('id', 'ci', 'nombre', 'apellidopaterno', 'apellidomaterno')
            ->where('estado', 1)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'cliente' => $cliente,
                'personas' => $personas
            ]
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'cliente_habitual' => 'required|in:0,1',
            'idpersona' => 'required|exists:personas,id',
        ]);

        $data = $request->all();
        $data['cliente_habitual'] = $request->cliente_habitual == "1" ? 1 : 0;

        $cliente->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Cliente actualizado correctamente',
            'data' => $cliente
        ]);
    }

    public function eliminar($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cliente eliminado correctamente'
        ]);
    }
}
