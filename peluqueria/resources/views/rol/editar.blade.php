@extends('layouts.plantilla')

@section('title', 'Editar Rol')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Editar Rol</h1>

    <form action="{{ route('rol.actualizar', $rol->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow space-y-4 border border-gray-200">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-semibold">Nombre:</label>
            <input type="text" name="nombre" class="w-full border px-3 py-2 rounded-lg" value="{{ old('nombre', $rol->nombre) }}">
            @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">Descripción:</label>
            <textarea name="descripcion" class="w-full border px-3 py-2 rounded-lg">{{ old('descripcion', $rol->descripcion) }}</textarea>
            @error('descripcion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">Estado:</label>
            <select name="estado" class="w-full border px-3 py-2 rounded-lg">
                <option value="1" {{ old('estado', $rol->estado) == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ old('estado', $rol->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-[#EE6983] text-white px-6 py-2 rounded-lg hover:bg-[#92487A] transition">
            Actualizar
        </button>
    </form>
</div>
@endsection
