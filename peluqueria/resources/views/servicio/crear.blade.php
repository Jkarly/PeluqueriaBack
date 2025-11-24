@extends('layouts.plantilla')

@section('title', 'Registrar Servicio')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Registrar Servicio</h1>

    <form action="{{ route('servicio.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-medium mb-1">Nombre:</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full border px-2 py-1 rounded @error('nombre') border-red-500 @enderror" required>
                @error('nombre')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Categoría:</label>
                <select name="idcategoria" class="w-full border px-2 py-1 rounded @error('idcategoria') border-red-500 @enderror" required>
                    <option value="">Seleccione categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('idcategoria') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('idcategoria')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Duración (min):</label>
                <input type="number" name="duracionmin" value="{{ old('duracionmin') }}" step="0.01" class="w-full border px-2 py-1 rounded @error('duracionmin') border-red-500 @enderror">
                @error('duracionmin')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Precio:</label>
                <input type="number" name="precio" value="{{ old('precio') }}" step="0.01" class="w-full border px-2 py-1 rounded @error('precio') border-red-500 @enderror" required>
                @error('precio')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Estado:</label>
                <select name="estado" class="w-full border px-2 py-1 rounded @error('estado') border-red-500 @enderror">
                    <option value="1" selected>Activo</option>
                    <option value="0">Inactivo</option>
                </select>
                @error('estado')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Imagen:</label>
                <input type="file" name="imagen" class="w-full @error('imagen') border-red-500 @enderror">
                @error('imagen')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Descripción:</label>
                <textarea name="descripcion" class="w-full border px-2 py-1 rounded @error('descripcion') border-red-500 @enderror"
                    rows="3">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mt-4">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Guardar</button>
            <a href="{{ route('servicio.index') }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 ml-2">Cancelar</a>
        </div>
    </form>
</div>
@endsection