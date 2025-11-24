<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ClienteAuthController extends Controller
{
    public function register(Request $request)
    {
        Log::info('=== INICIO REGISTRO CLIENTE ===');
        Log::info('Datos recibidos:', $request->all());

        // Validación de datos simplificada
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidopaterno' => 'required|string|max:100',
            'apellidomaterno' => 'required|string|max:100',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|min:8|confirmed',
        ]);

        DB::beginTransaction();
        
        try {
            // 1. Crear Persona
            $persona = Persona::create([
                'nombre' => $validated['nombre'],
                'apellidopaterno' => $validated['apellidopaterno'],
                'apellidomaterno' => $validated['apellidomaterno'],
                'telefono' => $validated['telefono'],
                'ci' => 'SIN CI', // Valor por defecto ya que es requerido
                'estado' => true, // Estado activo por defecto
            ]);

            Log::info('Persona creada:', $persona->toArray());

            // 2. Obtener rol CLIENTE (id 3)
            $rolCliente = Rol::where('nombre', 'CLIENTE')->first();
            
            if (!$rolCliente) {
                throw new \Exception('Rol CLIENTE no encontrado');
            }

            // 3. Crear Usuario
            $usuario = Usuario::create([
                'correo' => $validated['correo'],
                'contrasena' => Hash::make($validated['contrasena']),
                'estado' => true,
                'idpersona' => $persona->id,
                'idrol' => $rolCliente->id,
            ]);

            Log::info('Usuario creado:', $usuario->toArray());

            // 4. Crear Cliente
            $cliente = Cliente::create([
                'cliente_habitual' => 0, // Por defecto no es habitual
                'idpersona' => $persona->id,
            ]);

            Log::info('Cliente creado:', $cliente->toArray());

            DB::commit();

            // Crear token de autenticación
            $token = $usuario->createToken('auth_token')->plainTextToken;

            Log::info('=== REGISTRO EXITOSO ===');

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $usuario->id,
                    'correo' => $usuario->correo,
                    'persona' => $persona,
                    'rol' => $rolCliente,
                    'cliente' => $cliente
                ],
                'message' => 'Registro exitoso. ¡Bienvenido!'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en registro: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Error en el registro: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'correo' => 'required|email'
        ]);

        $exists = Usuario::where('correo', $request->correo)->exists();

        return response()->json([
            'available' => !$exists
        ]);
    }
}