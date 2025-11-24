<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $usuarios = Usuario::with(['persona', 'rol'])
            ->when($search, function($query, $search) {
                $query->whereHas('persona', function($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%")
                      ->orWhere('apellidopaterno', 'LIKE', "%{$search}%")
                      ->orWhere('apellidomaterno', 'LIKE', "%{$search}%");
                })->orWhere('correo', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(7);

        return response()->json([
            'success' => true,
            'data' => $usuarios
        ]);
    }

    public function crear()
    {
        $personas = Persona::select('id', 'nombre', 'apellidopaterno', 'apellidomaterno')->get();
        $roles = Rol::select('id', 'nombre')->where('estado', 1)->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'personas' => $personas,
                'roles' => $roles
            ]
        ]);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|string|min:6',
            'idpersona' => 'required|exists:personas,id',
            'idrol' => 'required|exists:rols,id',
            'estado' => 'required|boolean',
        ]);

        $data = $request->all();
        $data['contrasena'] = Hash::make($request->contrasena);

        $usuario = Usuario::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado correctamente',
            'data' => $usuario
        ], 201);
    }

    public function editar($id)
    {
        $usuario = Usuario::with(['persona', 'rol'])->findOrFail($id);
        $personas = Persona::select('id', 'nombre', 'apellidopaterno', 'apellidomaterno')->get();
        $roles = Rol::select('id', 'nombre')->where('estado', 1)->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'usuario' => $usuario,
                'personas' => $personas,
                'roles' => $roles
            ]
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'correo' => 'required|email|unique:usuarios,correo,' . $id,
            'idpersona' => 'required|exists:personas,id',
            'idrol' => 'required|exists:rols,id',
            'estado' => 'required|in:0,1',
        ]);

        $data = $request->all();
        $data['estado'] = $request->estado == "1" ? 1 : 0;

        // Si se proporciona nueva contraseña, hashearla
        if ($request->has('contrasena') && $request->contrasena) {
            $data['contrasena'] = Hash::make($request->contrasena);
        } else {
            unset($data['contrasena']);
        }

        $usuario->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente',
            'data' => $usuario
        ]);
    }

    public function eliminar($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente'
        ]);
    }
}
