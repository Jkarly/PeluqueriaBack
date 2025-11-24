<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerfilService extends Controller
{
    public function show(Request $request)
    {
        $usuario = $request->user()->load('persona', 'rol');

        return response()->json([
            'user' => $usuario
        ]);
    }

    /**
     * Actualiza datos básicos de usuario y persona
     */
    public function update(Request $request)
    {
        $usuario = $request->user()->load('persona', 'rol');

        $validated = $request->validate([
            'correo' => 'required|email|unique:usuarios,correo,' . $usuario->id,
            'persona.ci' => 'nullable|string|max:50',
            'persona.nombre' => 'required|string|max:255',
            'persona.apellidopaterno' => 'nullable|string|max:255',
            'persona.apellidomaterno' => 'nullable|string|max:255',
            'persona.telefono' => 'nullable|string|max:50',
        ]);

        // Actualizar correo del usuario
        $usuario->correo = $validated['correo'];
        $usuario->save();

        // Actualizar datos de persona (si existe)
        if ($usuario->persona) {
            $usuario->persona->update([
                'ci' => $validated['persona']['ci'] ?? $usuario->persona->ci,
                'nombre' => $validated['persona']['nombre'] ?? $usuario->persona->nombre,
                'apellidopaterno' => $validated['persona']['apellidopaterno'] ?? $usuario->persona->apellidopaterno,
                'apellidomaterno' => $validated['persona']['apellidomaterno'] ?? $usuario->persona->apellidomaterno,
                'telefono' => $validated['persona']['telefono'] ?? $usuario->persona->telefono,
            ]);
        }

        $usuario->load('persona', 'rol');

        return response()->json([
            'message' => 'Perfil actualizado correctamente',
            'user' => $usuario
        ]);
    }
}
