@extends('layouts.plantilla')

@section('title', 'Historial de Citas')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Mi Historial de Citas</h1>

    @if($datos->isEmpty())
        <p class="text-gray-500">No tienes citas registradas.</p>
    @else
        @php
            // Agrupar los detalles por idcita
            $citasAgrupadas = $datos->groupBy('idcita');
        @endphp

        @foreach($citasAgrupadas as $idcita => $detalles)
            @php
                $cita = $detalles->first()->cita;
            @endphp
            <div class="bg-white rounded-2xl shadow p-6 mb-6 border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">
                        Cita #{{ $cita->id }} - {{ \Carbon\Carbon::parse($cita->fechahorainicio)->format('d/m/Y H:i') }}
                    </h2>
                    <span class="font-semibold 
                        {{ $cita->estado == 1 ? 'text-green-500' : 'text-red-500' }}">
                        {{ $cita->estado == 1 ? 'Aceptada' : 'Pendiente' }}
                    </span>
                </div>

                <table class="w-full text-left border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border-b">Empleado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 py-2 border-b">
                                {{ $cita->empleado->persona->nombre ?? 'Empleado eliminado' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    @endif
</div>
@endsection
