@extends('layouts.plantilla')

@section('title', 'Crear Categoría')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Crear Categoría</h1>

    <form action="{{ route('categoria.guardar') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}"
                   class="w-full border px-4 py-2 rounded">
            @error('nombre') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Descripción:</label>
            <textarea name="descripcion" class="w-full border px-4 py-2 rounded">{{ old('descripcion') }}</textarea>
            @error('descripcion') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Estado:</label>
            <select name="estado" class="w-full border px-4 py-2 rounded">
                <option value="1" selected>Activo</option>
                <option value="0">Inactivo</option>
            </select>
            @error('estado') 
                <p class="text-red-600">{{ $message }}</p> 
            @enderror
        </div>


        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Guardar
        </button>
    </form>
</div>
@endsection
