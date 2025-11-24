@extends('layouts.plantilla')

@section('title', 'Listado de Servicios')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">Servicios Registrados</h1>
        <a href="{{ route('servicio.crear') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Nuevo Servicio</a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('servicio.index') }}" method="GET" class="mb-4 flex gap-2">
        <input type="text" name="search" placeholder="Buscar servicio..." value="{{ $search }}"
               class="border px-4 py-2 rounded">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Buscar</button>
        <a href="{{ route('servicio.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Limpiar</a>
    </form>

    <table class="min-w-full bg-white border">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 border">Nombre</th>
                <th class="px-4 py-2 border">Categoría</th>
                <th class="px-4 py-2 border">Duración</th>
                <th class="px-4 py-2 border">Precio</th>
                <th class="px-4 py-2 border">Estado</th>
                <th class="px-4 py-2 border">Imagen</th>
                <th class="px-4 py-2 border">Editar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($servicios as $servicio)
            <tr>
                <td class="px-4 py-2 border">{{ $servicio->nombre }}</td>
                <td class="px-4 py-2 border">{{ $servicio->categoria->nombre ?? 'N/A' }}</td>
                <td class="px-4 py-2 border">{{ $servicio->duracionmin ?? 'N/A' }}</td>
                <td class="px-4 py-2 border">{{ $servicio->precio }}</td>
                <td class="px-4 py-2 border">
                    <span class="{{ $servicio->estado ? 'text-green-600' : 'text-red-600' }}">
                        {{ $servicio->estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td class="px-4 py-2 border">
                    @if($servicio->imagen)
                        <img src="{{ asset('storage/images/servicio/'.$servicio->imagen) }}" class="w-12 h-12 object-cover rounded">
                    @else
                        N/A
                    @endif
                </td>
                <td class="px-4 py-2 border">
                    <a href="{{ route('servicio.editar', $servicio->id) }}" class="text-blue-600 hover:text-blue-800">Editar</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">No hay servicios registrados</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $servicios->links() }}
    </div>
</div>
@endsection
