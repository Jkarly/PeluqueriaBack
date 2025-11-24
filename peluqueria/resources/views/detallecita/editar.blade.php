@extends('layouts.plantilla')

@section('content')
<div class="container">
    <h2>Editar Detalle de Cita</h2>

    <form action="{{ route('detallecita.actualizar', $detalle->id) }}" method="POST">
        @csrf

        <select name="idcita" class="form-control" required>
            @foreach($citas as $c)
                <option value="{{ $c->id }}" {{ $detalle->idcita == $c->id ? 'selected' : '' }}>
                    Cita #{{ $c->id }} - 
                    {{ $c->cliente->persona->nombre }} 
                    {{ $c->cliente->persona->apellidopaterno }} 
                    {{ $c->cliente->persona->apellidomaterno }} 
                    - {{ $c->fechahorainicio }}
                </option>
            @endforeach
        </select>


        <div class="mb-3">
            <label>Servicio:</label>
            <select name="idservicio" class="form-control" required>
                @foreach($servicios as $s)
                    <option value="{{ $s->id }}" {{ $detalle->idservicio == $s->id ? 'selected' : '' }}>
                        {{ $s->nombre }} - Bs. {{ number_format($s->precio, 2) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Precio Cobrado:</label>
            <input type="number" step="0.01" name="preciocobrado" class="form-control" value="{{ $detalle->preciocobrado }}" required>
        </div>

        <div class="mb-3">
            <label>Observaciones:</label>
            <textarea name="observaciones" class="form-control">{{ $detalle->observaciones }}</textarea>
        </div>

        <button class="btn btn-warning">Actualizar</button>
    </form>
</div>
@endsection
