@extends('layouts.plantilla')

@section('title', 'Editar Categoría')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Editar Categoría</h1>

    <form action="{{ route('categoria.actualizar', $categoria->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre) }}"
                   class="w-full border px-4 py-2 rounded">
            @error('nombre') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Descripción:</label>
            <textarea name="descripcion" class="w-full border px-4 py-2 rounded">{{ old('descripcion', $categoria->descripcion) }}</textarea>
            @error('descripcion') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Estado:</label>
            <select name="estado" class="w-full border px-4 py-2 rounded">
                <option value="1" {{ old('estado', $categoria->estado) == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ old('estado', $categoria->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
            @error('estado') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Actualizar
        </button>
    </form>
</div>
@endsection
