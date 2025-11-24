@extends('layouts.plantilla')

@section('title', 'Listado de Roles')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Roles</h1>

    <a href="{{ route('rol.crear') }}" class="bg-[#EE6983] text-white px-4 py-2 rounded-lg hover:bg-[#92487A] transition mb-4 inline-block">
        Crear Rol
    </a>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full text-left border border-gray-200 rounded-lg">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Nombre</th>
                <th class="px-4 py-2 border-b">Descripción</th>
                <th class="px-4 py-2 border-b">Estado</th>
                <th class="px-4 py-2 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $rol)
            <tr>
                <td class="px-4 py-2 border-b">{{ $rol->id }}</td>
                <td class="px-4 py-2 border-b">{{ $rol->nombre }}</td>
                <td class="px-4 py-2 border-b">{{ $rol->descripcion }}</td>
                <td class="px-4 py-2 border-b">
                    <span class="{{ $rol->estado ? 'text-green-500' : 'text-red-500' }}">
                        {{ $rol->estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td class="px-4 py-2 border-b">
                    <a href="{{ route('rol.editar', $rol->id) }}" class="text-blue-500 hover:underline">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $roles->links() }}
    </div>
</div>
@endsection
