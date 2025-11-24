@extends('layouts.plantilla')

@section('title', 'Listado de Personas')

@section('content')

<div class="container mx-auto px-4">
    <div class="flex items-center justify-between mb-6">
        <x-titulo titulo="Personas Registradas" />
        <x-botoncrear :url="route('persona.crear')" texto="Nueva Persona" />
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <!-- FILTRO -->
    <x-filtros :titulo="'Filtrar Personas'" :action="route('persona.index')" method="GET">
        <div class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-grow w-full">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                    Buscar por CI, Nombre o Apellidos
                </label>
                <input type="text" name="search" id="search" placeholder="CI, Nombre o Apellidos"
                       value="{{ request('search') }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm 
                       focus:border-indigo-500 focus:ring-indigo-500 p-2">
            </div>

            <div class="flex gap-2 w-full sm:w-auto">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 
                    rounded-lg shadow-md transition">
                    Buscar
                </button>

                <a href="{{ route('persona.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 
                    rounded-lg shadow-md transition">
                    Limpiar
                </a>
            </div>
        </div>
    </x-filtros>

    {{-- TABLA --}}
    <div class="mt-6">
        @php
            $columns = ['CI', 'Nombre Completo', 'Teléfono', 'Estado', 'Editar'];

            $rows = [];

            foreach ($personas as $persona) {

                $actionHtml = view('components.boton_editar', [
                    'url' => route('persona.editar', $persona->id),
                ])->render();

                $estadoHtml = '
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ' .
                    ($persona->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') .
                '">
                    ' . ($persona->estado ? 'Activo' : 'Inactivo') . '
                </span>';

                $rows[] = [
                    $persona->ci,
                    $persona->nombre . ' ' . $persona->apellidopaterno . ' ' . $persona->apellidomaterno,
                    $persona->telefono ?? 'N/A',
                    $estadoHtml,
                    $actionHtml,
                ];
            }
        @endphp

        <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
            <x-tabla :columns="$columns" :rows="$rows" />
        </div>

        <div class="mt-6">
            {{ $personas->links() }}
        </div>
    </div>
</div>

@endsection
