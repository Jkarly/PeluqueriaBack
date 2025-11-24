@extends('layouts.plantilla')

@section('content')

<div class="container mx-auto p-4 sm:p-6 lg:p-8">
<div class="flex justify-between items-center mb-6">
<h1 class="text-3xl font-bold text-gray-800">Panel de Citas</h1>
{{-- Enlace para crear si se requiere que los empleados también puedan crear,
aunque la lógica actual solo lo permite a clientes.
Se deja comentado si no aplica: --}}
{{-- <a href="{{ route('cita.crear') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
Crear Nueva Cita
</a> --}}
</div>

{{-- Formulario de Búsqueda --}}
<form action="{{ route('cita.index') }}" method="GET" class="mb-6">
    <div class="flex items-center space-x-2 bg-white p-3 rounded-lg shadow-lg">
        <input 
            type="text" 
            name="buscar" 
            placeholder="Buscar por nombre de Cliente..." 
            value="{{ $buscar ?? '' }}"
            class="flex-1 p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
        >
        <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white p-2.5 rounded-lg transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
        </button>
        @if($buscar)
            <a href="{{ route('cita.index') }}" class="text-gray-500 hover:text-gray-700 p-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        @endif
    </div>
</form>

{{-- Mensajes de Sesión (Éxito/Error) --}}
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

{{-- Tabla de Citas --}}
<div class="overflow-x-auto bg-white rounded-lg shadow-lg">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empleado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha/Hora Inicio</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($citas as $cita)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cita->id }}</td>
                    {{-- Asume que la relación 'cliente' existe y el modelo Cliente tiene una relación 'persona' --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $cita->cliente->persona->nombre ?? 'N/A' }}
                    </td>
                    {{-- Asume que la relación 'empleado' existe y el modelo Empleado tiene una relación 'persona' --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $cita->empleado->persona->nombre ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($cita->fechahorainicio)->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($cita->estado == 'Pendiente') bg-yellow-100 text-yellow-800
                            @elseif($cita->estado == 'Confirmada') bg-blue-100 text-blue-800
                            @elseif($cita->estado == 'Completada') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $cita->estado }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('cita.editar', $cita->id) }}" class="text-indigo-600 hover:text-indigo-900 transition duration-300">
                            Editar
                        </a>
                        
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        No se encontraron citas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Paginación --}}
<div class="mt-6">
    {{ $citas->links() }}
</div>


</div>
@endsection