@extends('layouts.plantilla')
@section('content')

<div class="max-w-4xl mx-auto p-6 bg-white shadow-2xl rounded-2xl mt-10">

<div class="flex items-center justify-between mb-8 border-b pb-4">
    <h1 class="text-3xl font-extrabold text-[#333]">
        <i class="fas fa-calendar-plus text-[#EE6983] mr-3"></i>
        Reservar Nueva Cita
    </h1>
    {{-- CORRECCIÓN: Usar 'cita.index' --}}
    <a href="{{ route('cita.index') }}" class="text-gray-500 hover:text-[#92487A] transition-colors">
        <i class="fas fa-arrow-left mr-1"></i> Volver al Listado
    </a>
</div>

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6" role="alert">
        <strong class="font-bold">¡Oops! Hubo un problema:</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- CORRECCIÓN: Usar 'cita.guardar' --}}
<form action="{{ route('cita.guardar') }}" method="POST" class="space-y-6">
    @csrf

    {{-- ID USUARIO CREADOR (OCULTO y PRE-LLENADO) --}}
    <input type="hidden" name="idusuariocreador" value="{{ $idusuariocreador }}">

    {{-- ID CLIENTE (OCULTO y PRE-LLENADO, solo informativo para el cliente) --}}
    <input type="hidden" name="idcliente" value="{{ $idcliente }}">
    
    {{-- Muestra el cliente de forma informativa --}}
    <div class="w-full mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Tu Cuenta de Cliente (Automático)
        </label>
        <div class="mt-1 p-3 bg-indigo-50 border border-indigo-200 text-indigo-800 rounded-xl font-semibold">
            {{ $cliente->persona->nombre }} {{ $cliente->persona->apellidopaterno }}
            <span class="text-sm italic block mt-1">(Tu ID de Cliente: {{ $idcliente }})</span>
        </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        {{-- CAMPO FECHA Y HORA --}}
        <div class="col-span-1">
            <label for="fechahorainicio" class="block text-sm font-medium text-gray-700 mb-2">Fecha y Hora de Inicio</label>
            <input type="datetime-local" name="fechahorainicio" id="fechahorainicio" 
                    value="{{ old('fechahorainicio') }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm p-3 focus:ring-[#EE6983] focus:border-[#EE6983]">
            @error('fechahorainicio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- CAMPO ESTADO (PENDIENTE por defecto) --}}
        <div class="col-span-1">
            <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado de la Cita</label>
            <input type="text" value="PENDIENTE" disabled
                   class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm p-3 bg-gray-100 text-gray-500 font-semibold">
            {{-- Campo real, oculto para que siempre sea PENDIENTE --}}
            <input type="hidden" name="estado" value="PENDIENTE"> 
        </div>
    </div>

    {{-- CAMPO EMPLEADO --}}
    <div class="w-full">
        <label for="idempleado" class="block text-sm font-medium text-gray-700 mb-2">
            Seleccionar Empleado (Especialista)
        </label>
        <select name="idempleado" id="idempleado" required
                class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm p-3 focus:ring-[#EE6983] focus:border-[#EE6983]">
            <option value="">-- Seleccione un empleado --</option>
            @foreach($empleados as $empleado)
                <option value="{{ $empleado->id }}" 
                        @if(old('idempleado') == $empleado->id) selected @endif>
                    {{ $empleado->persona->nombre }} {{ $empleado->persona->apellidopaterno }}
                </option>
            @endforeach
        </select>
        @error('idempleado') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- BOTÓN DE RESERVA --}}
    <div class="pt-4 flex justify-end">
        <button type="submit" class="bg-[#EE6983] text-white px-8 py-3 rounded-xl text-lg font-bold 
                                     hover:bg-[#92487A] transition-all duration-300 flex items-center shadow-lg 
                                     transform hover:scale-[1.02]">
            <i class="fas fa-save mr-3"></i>
            Confirmar Reserva
        </button>
    </div>
</form>
</div>
@endsection