<?php

namespace App\Controllers;

use App\Services\ReporteService;
use App\Core\Response;

class ReporteController
{
    public static function estadisticas(): void
    {
        try {
            $estadisticas = ReporteService::obtenerResumen();
            Response::success($estadisticas, "Resumen de incidencias");
        } catch (\Exception $e) {
            Response::error("Error al obtener reporte: " . $e->getMessage(), 500);
        }
    }

    public static function exportCsv(): void
    {
        // 1) Leer y sanitizar parámetros
        $inicio = $_GET['inicio'] ?? date('Y-m-01');
        $fin    = $_GET['fin']    ?? date('Y-m-d');

        // 2) Obtener datos
        $incidencias = ReporteService::obtenerPorRango($inicio, $fin);

        // 3) Cabeceras HTTP para CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="reporte_incidencias_'.$inicio.'_a_'.$fin.'.csv"');

        // 4) Salida
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID','Tipo','Estado','Fecha']);

        foreach ($incidencias as $row) {
            fputcsv($output, [
                $row['id'],
                $row['tipo'],
                $row['estado'],
                $row['fecha_reporte']
            ]);
        }
        fclose($output);
        exit;
    }
}
