@extends('layouts.plantilla')

@section('content')
<div class="container">
    <h2>Detalle de Citas</h2>

    <a href="{{ route('detallecita.crear') }}" class="btn btn-primary mb-3">Nuevo Detalle</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Precio Cobrado</th>
                <th>Observaciones</th>
                <th>Cita</th>
                <th>Servicio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($datos as $d)
            <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->preciocobrado }}</td>
                <td>{{ $d->observaciones }}</td>
                <td>{{ $d->cita->id }}</td>
                <td>{{ $d->servicio->nombre ?? 'N/A' }}</td>

                <td>
                    <a href="{{ route('detallecita.editar', $d->id) }}" class="btn btn-warning btn-sm">
                        Editar
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
