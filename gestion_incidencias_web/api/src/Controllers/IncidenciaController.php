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

    public static function actualizarEstado(array $data): void
    {
        if (empty($data['incidencia_id']) || empty($data['nuevo_estado'])) {
            Response::error("Datos incompletos", 422);
        }

        $resultado = IncidenciaService::actualizarEstado($data['incidencia_id'], $data['nuevo_estado']);

        if ($resultado) {
            Response::success([], "Estado actualizado correctamente");
        } else {
            Response::error("No se pudo actualizar el estado", 500);
        }
    }

    public static function asignarEmpleado(array $data): void
    {
        if (empty($data['incidencia_id']) || empty($data['empleado_id'])) {
            Response::error("Datos incompletos para la asignación", 422);
        }

        $asignado = IncidenciaService::asignarEmpleado($data['incidencia_id'], $data['empleado_id']);

        if ($asignado) {
            Response::success([], "Incidencia asignada correctamente");
        } else {
            Response::error("Error al asignar la incidencia", 500);
        }
    }

    public static function obtenerPorEmpleado(int $empleadoId): void
    {
        try {
            $incidencias = IncidenciaService::obtenerPorEmpleado($empleadoId);

            foreach ($incidencias as &$incidencia) {
                if (isset($incidencia['foto']) && !empty($incidencia['foto'])) {
                    if (is_resource($incidencia['foto'])) {
                        $binario = stream_get_contents($incidencia['foto']);
                        $incidencia['foto'] = base64_encode($binario);
                    } else {
                        $incidencia['foto'] = base64_encode($incidencia['foto']);
                    }
                }
            }

            Response::success($incidencias, "Incidencias asignadas al empleado");
        } catch (\Exception $e) {
            Response::error("Error al obtener incidencias: " . $e->getMessage(), 500);
        }
    }
}
