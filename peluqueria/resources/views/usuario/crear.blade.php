@extends('layouts.plantilla')

@section('title', 'Crear Usuario')

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
    <x-form formTitle="Crear Nuevo Usuario" :action="route('usuario.guardar')" method="POST" submitText="Guardar">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Correo</label>
            <input type="email" name="correo" required class="w-full border rounded p-2 mb-4" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Contraseña</label>
            <input type="password" name="contrasena" required class="w-full border rounded p-2 mb-4" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Estado</label>
            <select name="estado" required class="w-full border rounded p-2 mb-4">
                <option value="1" selected>Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Persona</label>
            <select name="idpersona" required class="w-full border rounded p-2 mb-4">
                @foreach ($personas as $persona)
                    <option value="{{ $persona->id }}">{{ $persona->nombre }} {{ $persona->apellidopaterno }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Rol</label>
            <select name="idrol" required class="w-full border rounded p-2 mb-4">
                @foreach ($rols as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                @endforeach
            </select>
        </div>

    </x-form>
@endsection
