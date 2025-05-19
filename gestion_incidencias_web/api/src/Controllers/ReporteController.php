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
}
