<!DOCTYPE html> 
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte Ganancia Neta Diaria</title>

<style>
    body{
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
    }

    .header-table{
        width:100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    .logo-cell{
        width: 20%;
        text-align: left;
        vertical-align: middle;
    }

    .logo{
        height: 70px;
    }

    .titulo-cell{
        width: 80%;
        text-align: center;
        vertical-align: middle;
    }

    .titulo{
        font-size:21px;
        font-weight: bold;
        color:#c2185b;
        margin-bottom:4px;
    }

    .sub{
        font-weight:bold;
        font-size:13px;
        color:#7b1fa2;
    }

    table{
        width:100%;
        border-collapse:collapse;
        margin-top:15px;
    }

    th{
        background:#f8bbd0;
        padding:5px;
        border:1px solid #f48fb1;
    }

    td{
        padding:6px;
        border:1px solid #f8bbd0;
    }

    tfoot td{
        background:#fce4ec;
        font-weight:bold;
    }

    .right{text-align:right}
    .center{text-align:center}

</style>
</head>

<body>

{{-- ENCABEZADO CON LOGO Y TÍTULO --}}
<table class="header-table">
    <tr>
        <td class="logo-cell">
            <img 
                src="{{ public_path('storage/imagenreporte/logo.png') }}" 
                alt="Logo Peluquería" 
                class="logo"
            >
        </td>
        <td class="titulo-cell">
            <div class="titulo">REPORTE DE GANANCIA NETA POR DÍA</div>
            <div class="sub">
                @if($fechaInicio || $fechaFin)
                    Rango: <strong>{{ $fechaInicio ?: 'inicio' }} → {{ $fechaFin ?: 'fin' }}</strong>
                @else
                    Todas las fechas
                @endif
            </div>
        </td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th class="right">Ingresos</th>
            <th class="right">Costo Productos</th>
            <th class="right">Ganancia Neta</th>
        </tr>
    </thead>

    <tbody>
        @forelse($rows as $r)
            <tr>
                <td>{{ $r['fecha'] }}</td>
                <td class="right">{{ number_format($r['ingresos'],2) }}</td>
                <td class="right">{{ number_format($r['costo_productos'],2) }}</td>
                <td class="right">{{ number_format($r['ganancia_neta'],2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="center">No hay datos</td>
            </tr>
        @endforelse
    </tbody>

    <tfoot>
        <tr>
            <td class="right">Totales</td>
            <td class="right">{{ number_format($totales['total_ingresos'],2) }}</td>
            <td class="right">{{ number_format($totales['total_costo_productos'],2) }}</td>
            <td class="right">{{ number_format($totales['total_ganancia_neta'],2) }}</td>
        </tr>
    </tfoot>
</table>

<br><br>

<div style="text-align:right; font-size:11px; color:#555">
    Generado: {{ $generadoEl->format('d/m/Y H:i') }}
</div>

</body>
</html>
