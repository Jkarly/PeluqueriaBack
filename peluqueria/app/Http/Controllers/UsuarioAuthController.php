<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
class UsuarioAuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.usuario_login');
    }

    public function login(Request $request)
    {
        Log::info('=== INICIO LOGIN ===');
        Log::info('Datos recibidos:', $request->all());

        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required'
        ]);

        // Buscar usuario por correo
        $usuario = Usuario::where('correo', $request->correo)->first();
        
        Log::info('Usuario encontrado:', [$usuario ? $usuario->toArray() : 'NO ENCONTRADO']);

        if (!$usuario) {
            Log::info('ERROR: Usuario no encontrado');
            return response()->json([
                'error' => 'Credenciales incorrectas'
            ], 401);
        }

        // Verificar contraseña
        $passwordMatch = Hash::check($request->contrasena, $usuario->contrasena);
        Log::info('Contraseña coincide:', [$passwordMatch ? 'SÍ' : 'NO']);
        Log::info('Contraseña recibida:', [$request->contrasena]);
        Log::info('Contraseña en DB:', [$usuario->contrasena]);

        if (!$passwordMatch) {
            Log::info('ERROR: Contraseña incorrecta');
            return response()->json([
                'error' => 'Credenciales incorrectas'
            ], 401);
        }

        // Verificar si el usuario está activo
        Log::info('Estado usuario:', [$usuario->estado]);
        if (!$usuario->estado) {
            Log::info('ERROR: Usuario inactivo');
            return response()->json([
                'error' => 'Usuario inactivo'
            ], 401);
        }

        Log::info('=== LOGIN EXITOSO ===');

        // Crear token
        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $usuario->id,
                'correo' => $usuario->correo,
                'persona' => $usuario->persona,
                'rol' => $usuario->rol
            ]
        ]);
    }
    public function logout(Request $request)
    {
        Log::info('=== INICIO LOGOUT ===');
        Log::info('Usuario:', [$request->user() ? $request->user()->id : 'NO AUTENTICADO']);

        try {
            if ($request->expectsJson()) {
                // Revocar el token actual
                if ($request->user()) {
                    $request->user()->currentAccessToken()->delete();
                    Log::info('Token revocado correctamente');
                }
                
                return response()->json([
                    'message' => 'Sesión cerrada correctamente'
                ]);
            }

            // Para web tradicional
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login');
            
        } catch (\Exception $e) {
            Log::error('Error durante logout: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Sesión cerrada (con errores)'
                ], 200);
            }
            
            return redirect()->route('login');
        }
    }

    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user()->load('persona', 'rol')
        ]);
    }
}

?>