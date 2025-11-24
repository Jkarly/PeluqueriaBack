@extends('layouts.plantilla')

@section('title', 'Listado de Categorías')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Categorías</h1>

    <div class="mb-4 flex justify-between">
        <form action="{{ route('categoria.index') }}" method="GET" class="flex">
            <input type="text" name="search" placeholder="Buscar..." value="{{ $search }}"
                class="border px-4 py-2 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-lg hover:bg-indigo-700">
                Buscar
            </button>
        </form>
        <a href="{{ route('categoria.crear') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            Crear Categoría
        </a>
    </div>

    <table class="min-w-full bg-white border">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 border">ID</th>
                <th class="py-2 px-4 border">Nombre</th>
                <th class="py-2 px-4 border">Descripción</th>
                <th class="py-2 px-4 border">Estado</th>
                <th class="py-2 px-4 border">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categorias as $categoria)
                <tr>
                    <td class="py-2 px-4 border">{{ $categoria->id }}</td>
                    <td class="py-2 px-4 border">{{ $categoria->nombre }}</td>
                    <td class="py-2 px-4 border">{{ $categoria->descripcion }}</td>
                    <td class="py-2 px-4 border">
                        <span class="{{ $categoria->estado ? 'text-green-600' : 'text-red-600' }}">
                            {{ $categoria->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="py-2 px-4 border">
                        <a href="{{ route('categoria.editar', $categoria->id) }}"
                           class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">
                            Editar
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">No se encontraron categorías.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $categorias->links() }}
    </div>
</div>
@endsection
