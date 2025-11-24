<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Detalle_cita;
use App\Models\ProductoUtilizado;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    private $ROL_ADMIN = 1;
    private $ROL_EMPLEADO = 2;
    private $ROL_CLIENTE = 3;

    /**
     * Construye los datos de ganancia neta por día
     * (ingresos, costos, totales) para JSON y PDF.
     */
    private function buildGananciaNetaData(Request $request): array
    {
        $usuario = Auth::user();

        // Solo admin y empleados pueden ver el reporte
        if (!in_array($usuario->idrol, [$this->ROL_ADMIN, $this->ROL_EMPLEADO])) {
            abort(403, 'Acceso denegado');
        }

        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // ==========================
        //  INGRESOS (solo estado=1)
        // ==========================
        $ingresosQuery = Detalle_cita::query()
            ->selectRaw('DATE(citas.fechahorainicio) as fecha, SUM(detalle_citas.preciocobrado) as ingresos')
            ->join('citas', 'detalle_citas.idcita', '=', 'citas.id')
            ->where('detalle_citas.estado', 1); // SOLO detalles pagados

        if ($fechaInicio) {
            $ingresosQuery->whereDate('citas.fechahorainicio', '>=', $fechaInicio);
        }

        if ($fechaFin) {
            $ingresosQuery->whereDate('citas.fechahorainicio', '<=', $fechaFin);
        }

        $ingresosPorDia = $ingresosQuery
            ->groupBy('fecha')
            ->pluck('ingresos', 'fecha');

        // ========================================
        //  COSTO PRODUCTOS (productos_utilizados)
        // ========================================
        $costosQuery = ProductoUtilizado::query()
            ->selectRaw('DATE(citas.fechahorainicio) as fecha, SUM(producto_utilizados.cantidad * productos.costo) as costo_productos')
            ->join('citas', 'producto_utilizados.idcita', '=', 'citas.id')
            ->join('productos', 'producto_utilizados.idproducto', '=', 'productos.id')
            ->where('producto_utilizados.estado', 1); // Solo productos activos

        if ($fechaInicio) {
            $costosQuery->whereDate('citas.fechahorainicio', '>=', $fechaInicio);
        }

        if ($fechaFin) {
            $costosQuery->whereDate('citas.fechahorainicio', '<=', $fechaFin);
        }

        $costosPorDia = $costosQuery
            ->groupBy('fecha')
            ->pluck('costo_productos', 'fecha');

        // ==========================
        //  UNIR FECHAS Y CALCULAR
        // ==========================
        $fechas = $ingresosPorDia->keys()
            ->merge($costosPorDia->keys())
            ->unique()
            ->sort();

        $resultado = [];
        $totalIngresos = 0;
        $totalCostos = 0;
        $totalGanancia = 0;

        foreach ($fechas as $fecha) {
            $ingresos = (float) ($ingresosPorDia[$fecha] ?? 0);
            $costo = (float) ($costosPorDia[$fecha] ?? 0);
            $ganancia = $ingresos - $costo;

            $resultado[] = [
                'fecha'           => $fecha,
                'ingresos'        => $ingresos,
                'costo_productos' => $costo,
                'ganancia_neta'   => $ganancia,
            ];

            $totalIngresos += $ingresos;
            $totalCostos   += $costo;
            $totalGanancia += $ganancia;
        }

        return [
            'data' => $resultado,
            'totales' => [
                'total_ingresos'        => $totalIngresos,
                'total_costo_productos' => $totalCostos,
                'total_ganancia_neta'   => $totalGanancia,
            ],
            'filtros' => [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin'    => $fechaFin,
            ],
        ];
    }

    /**
     * JSON: /api/reportes/ganancia-neta-diaria
     */
    public function gananciaNetaPorDia(Request $request)
    {
        $payload = $this->buildGananciaNetaData($request);

        return response()->json([
            'success' => true,
            'data'    => $payload['data'],
            'totales' => $payload['totales'],
        ]);
    }

    /**
     * PDF: /api/reportes/ganancia-neta-diaria/pdf
     */
    public function gananciaNetaDiariaPdf(Request $request)
    {
        $payload = $this->buildGananciaNetaData($request);

        $rows    = $payload['data'];
        $totales = $payload['totales'];
        $filtros = $payload['filtros'];

        $fechaInicio = $filtros['fecha_inicio'];
        $fechaFin    = $filtros['fecha_fin'];

        $pdf = Pdf::loadView('reportes.ganancia_neta_diaria', [
            'rows'       => $rows,
            'totales'    => $totales,
            'fechaInicio'=> $fechaInicio,
            'fechaFin'   => $fechaFin,
            'generadoEl' => now(),
        ])->setPaper('a4', 'portrait');

        $fileName = 'reporte-ganancia-neta-diaria-' .
            ($fechaInicio ?: 'inicio') . '-' .
            ($fechaFin ?: 'fin') . '.pdf';

        return $pdf->stream($fileName);
    }

}
