@extends('layouts.plantilla')

@section('title', 'Editar Servicio')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Editar Servicio</h1>

    <form action="{{ route('servicio.actualizar', $servicio->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-medium mb-1">Nombre:</label>
                <input type="text" name="nombre" value="{{ old('nombre', $servicio->nombre) }}" class="w-full border px-2 py-1 rounded @error('nombre') border-red-500 @enderror" required>
                @error('nombre')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Categoría:</label>
                <select name="idcategoria" class="w-full border px-2 py-1 rounded @error('idcategoria') border-red-500 @enderror" required>
                    <option value="">Seleccione categoría</option> {{-- Agregado para consistencia --}}
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('idcategoria', $servicio->idcategoria) == $categoria->id ? 'selected' : '' }}>
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
                <input type="number" name="duracionmin" value="{{ old('duracionmin', $servicio->duracionmin) }}" step="0.01" class="w-full border px-2 py-1 rounded @error('duracionmin') border-red-500 @enderror">
                @error('duracionmin')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Precio:</label>
                <input type="number" name="precio" value="{{ old('precio', $servicio->precio) }}" step="0.01" class="w-full border px-2 py-1 rounded @error('precio') border-red-500 @enderror" required>
                @error('precio')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Estado:</label>
                <select name="estado" class="w-full border px-2 py-1 rounded @error('estado') border-red-500 @enderror">
                    {{-- Corrección: Usa el valor de la base de datos o old, comparado con el valor de la opción --}}
                    <option value="1" {{ old('estado', $servicio->estado) == '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('estado', $servicio->estado) == '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('estado')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Imagen:</label>
                <input type="file" name="imagen" class="w-full @error('imagen') border-red-500 @enderror">
                @if($servicio->imagen)
                    <p class="text-sm mt-1">Imagen actual:</p>
                    <img src="{{ asset('storage/images/servicio/'.$servicio->imagen) }}" class="w-24 h-24 mt-1 object-cover rounded">
                @endif
                @error('imagen')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block font-medium mb-1">Descripción:</label>
                <textarea name="descripcion" rows="3"
                    class="w-full border px-2 py-1 rounded @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
            <a href="{{ route('servicio.index') }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 ml-2">Cancelar</a>
        </div>
    </form>
</div>
@endsection