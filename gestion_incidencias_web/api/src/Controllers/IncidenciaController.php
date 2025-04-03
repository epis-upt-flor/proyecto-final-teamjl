<?php
namespace App\Controllers;

use App\Services\IncidenciaService;
use App\Core\Response;

class IncidenciaController
{
    public static function listar(): void
    {
        try {
            $data = IncidenciaService::obtenerTodas();
            Response::success($data, "Listado de incidencias");
        } catch (\Exception $e) {
            Response::error("Error al obtener incidencias: " . $e->getMessage(), 500);
        }
    }
}
