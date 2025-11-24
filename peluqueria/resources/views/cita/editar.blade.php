@extends('layouts.plantilla')

@section('content')

<div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-lg">
<div class="bg-white p-8 rounded-xl shadow-2xl">
<h1 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Editar Cita #{{ $cita->id }}</h1>

    {{-- Mensajes de Error de Validación --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">¡Oops!</strong>
            <span class="block sm:inline">Hubo algunos problemas con tu entrada.</span>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cita.actualizar', $cita->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Método para actualizaciones en REST --}}

        {{-- Campo Fecha/Hora de Inicio --}}
        <div class="mb-4">
            <label for="fechahorainicio" class="block text-sm font-medium text-gray-700 mb-1">Fecha y Hora de Inicio:</label>
            <input 
                type="datetime-local" 
                name="fechahorainicio" 
                id="fechahorainicio" 
                value="{{ old('fechahorainicio', \Carbon\Carbon::parse($cita->fechahorainicio)->format('Y-m-d\TH:i')) }}"
                required 
                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('fechahorainicio') border-red-500 @enderror"
            >
        </div>

        {{-- Campo Estado --}}
        <div class="mb-4">
            <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado:</label>
            <select 
                name="estado" 
                id="estado" 
                required 
                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('estado') border-red-500 @enderror"
            >
                @php
                    $estados = ['Pendiente', 'Confirmada', 'Completada', 'Cancelada'];
                @endphp
                @foreach($estados as $estado)
                    <option 
                        value="{{ $estado }}" 
                        @if(old('estado', $cita->estado) == $estado) selected @endif
                    >
                        {{ $estado }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Campo Cliente (Solo si se permite cambiar el cliente) --}}
        <div class="mb-4">
            <label for="idcliente" class="block text-sm font-medium text-gray-700 mb-1">Cliente:</label>
            <select 
                name="idcliente" 
                id="idcliente" 
                required 
                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('idcliente') border-red-500 @enderror"
            >
                @foreach($clientes as $cliente)
                    <option 
                        value="{{ $cliente->id }}" 
                        @if(old('idcliente', $cita->idcliente) == $cliente->id) selected @endif
                    >
                        {{ $cliente->persona->nombre ?? 'Cliente sin nombre' }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Campo Empleado --}}
        <div class="mb-6">
            <label for="idempleado" class="block text-sm font-medium text-gray-700 mb-1">Empleado Asignado:</label>
            <select 
                name="idempleado" 
                id="idempleado" 
                required 
                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('idempleado') border-red-500 @enderror"
            >
                @foreach($empleados as $empleado)
                    <option 
                        value="{{ $empleado->id }}" 
                        @if(old('idempleado', $cita->idempleado) == $empleado->id) selected @endif
                    >
                        {{ $empleado->persona->nombre ?? 'Empleado sin nombre' }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Botones de Acción --}}
        <div class="flex justify-between items-center">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                Guardar Cambios
            </button>
            <a href="{{ route('cita.index') }}" class="text-gray-600 hover:text-gray-800 transition duration-300 py-2 px-4 rounded-lg border border-gray-300 hover:bg-gray-50">
                Cancelar
            </a>
        </div>
    </form>
</div>


</div>
@endsection