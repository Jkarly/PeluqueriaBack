@extends('layouts.plantilla')

@section('title', 'Editar Usuario')

@section('content')
    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-300 bg-red-100 p-4 text-red-800 shadow">
            <div class="font-semibold text-red-700 mb-2">¡Ups! Hubo algunos errores:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <x-form action="{{ route('usuario.actualizar', $usuario->id) }}" method="PUT" formTitle="Editar Usuario"
        submitText="Actualizar" cancelUrl="{{ route('usuario.index') }}" width="max-w-lg">
        {{-- Correo --}}
        <div>
            <label for="correo" class="block font-medium text-gray-700">Correo</label>
            <input type="email" name="correo" id="correo" value="{{ old('correo', $usuario->correo) }}" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-emerald-400" />
        </div>

        {{-- Contraseña (Opcional para edición) --}}
        <div>
            <label for="contrasena" class="block font-medium text-gray-700">
                Contraseña 
                <span class="text-sm text-gray-500 font-normal">(Dejar en blanco para mantener la actual)</span>
            </label>
            <input type="password" name="contrasena" id="contrasena" 
                placeholder="Nueva contraseña (opcional)"
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-emerald-400" />
        </div>

        {{-- Persona --}}
        <div>
            <label for="idpersona" class="block font-medium text-gray-700">Personas</label>
            <select name="idpersona" id="idpersona" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-emerald-400">
                @foreach ($personas as $persona)
                    <option value="{{ $persona->id }}" {{ $usuario->idpersona == $persona->id ? 'selected' : '' }}>
                        {{ $persona->nombre }} {{ $persona->apellidopaterno }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="idrol" class="block font-medium text-gray-700">Rol</label>
            <select name="idrol" id="idrol" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-emerald-400">
                @foreach ($rols as $rol)
                    <option value="{{ $rol->id }}" {{ $usuario->idrol == $rol->id ? 'selected' : '' }}>
                        {{ $rol->nombre }}
                    </option>
                @endforeach
            </select>
        </div>


        {{-- Estado --}}
        <div>
            <label for="estado" class="block font-medium text-gray-700">Estado</label>
            <select name="estado" id="estado" required
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-emerald-400">
                <option value="1" {{ $usuario->estado ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ !$usuario->estado ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
    </x-form>
@endsection