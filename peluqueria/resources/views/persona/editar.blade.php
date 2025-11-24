@extends('layouts.plantilla')

@section('title', 'Editar Persona')

@section('content')
<div class="container mx-auto px-4 py-8">

    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-100 p-4 text-red-800 shadow-md">
            <h4 class="font-bold mb-2">Hay problemas con tu envío:</h4>
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-form formTitle="Editar Persona: {{ $persona->nombre }} {{ $persona->apellidopaterno }}"
        :action="route('persona.actualizar', $persona->id)"
        method="POST"
        submitText="Actualizar"
        cancelUrl="{{ route('persona.index') }}">

        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CI</label>
                <input type="text" name="ci" value="{{ old('ci', $persona->ci) }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 p-2"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre(s)</label>
                <input type="text" name="nombre" value="{{ old('nombre', $persona->nombre) }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 p-2"
                    required minlength="3">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Apellido Paterno</label>
                <input type="text" name="apellidopaterno" value="{{ old('apellidopaterno', $persona->apellidopaterno) }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 p-2"
                    required minlength="3">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Apellido Materno</label>
                <input type="text" name="apellidomaterno" value="{{ old('apellidomaterno', $persona->apellidomaterno) }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 p-2"
                    required minlength="3">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                <input type="number" name="telefono" value="{{ old('telefono', $persona->telefono) }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 p-2">
            </div>

        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
            <select name="estado"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 p-2"
                required>
                <option value="1" {{ old('estado', $persona->estado) == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ old('estado', $persona->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

    </x-form>

</div>
@endsection
