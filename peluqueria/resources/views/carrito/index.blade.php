@extends('layouts.plantilla')

@section('title','Mi carrito')

@section('content')
<div class="container py-8">
    <h2 class="text-2xl font-bold mb-6">Carrito de servicios</h2>

    @if($servicios->isEmpty())
        <p class="text-gray-600 text-lg">Tu carrito está vacío.</p>
        <a href="{{ route('servicio.catalogo') }}" class="btn btn-primary mt-3">
            Volver al catálogo
        </a>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Precio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicios as $s)
                <tr>
                    <td>{{ $s->nombre }}</td>
                    <td>Bs {{ number_format($s->precio,2) }}</td>
                    <td>
                        <form action="{{ route('carrito.eliminar',$s->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Quitar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('cita.reservar') }}" class="btn btn-success mt-4">
            Proceder a reservar cita
        </a>
    @endif
</div>
@endsection
