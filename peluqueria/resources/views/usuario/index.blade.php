@extends('layouts.plantilla')

@section('title', 'Listado de Usuarios')

@section('content')
<div class="container mx-auto px-4">
    {{-- Título y botón crear --}}
    <div class="flex items-center justify-between mb-4">
        <x-titulo titulo="Usuarios Registrados" />
        <x-botoncrear :url="route('usuario.crear')" texto="Nuevo Usuario" />
    </div>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- 🔍 Filtro de búsqueda azul --}}
    <x-filtros titulo="Filtrar Usuarios" :action="route('usuario.index')" method="GET">
        <div class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-grow w-full">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                    Buscar por nombre o apellido
                </label>
                <input type="text" name="search" id="search" placeholder="Buscar..."
                    value="{{ request('search') }}"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2" />
            </div>

            <div class="flex gap-2 w-full sm:w-auto">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg px-6 py-2 transition-colors">
                    Buscar
                </button>
                <a href="{{ route('usuario.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg px-6 py-2 transition-colors">
                    Limpiar
                </a>
            </div>
        </div>
    </x-filtros>

    {{-- Tabla de Usuarios --}}
    @php
        $columns = ['Correo', 'Persona', 'Rol', 'Estado', 'Acciones'];
        $rows = [];

        foreach ($usuarios as $user) {
            // Estado con colores
            $estadoHtml = $user->estado 
                ? '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activo</span>'
                : '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactivo</span>';

            // Botón editar con componente
            $accionesHtml = view('components.boton_editar', [
                'url' => route('usuario.editar', $user->id)
            ])->render();

            $rows[] = [
                e($user->correo),
                e($user->persona->nombre . ' ' . $user->persona->apellidopaterno),
                e($user->rol->nombre ?? 'Sin rol'), // <-- Aquí mostramos el nombre del rol
                $estadoHtml,
                $accionesHtml,
            ];
        }
    @endphp


    <x-tabla :columns="$columns" :rows="$rows" />

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $usuarios->links() }}
    </div>
</div>
@endsection
