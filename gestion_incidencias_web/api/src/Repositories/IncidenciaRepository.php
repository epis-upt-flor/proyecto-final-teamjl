<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class IncidenciaRepository
{
    public static function obtenerTodas(): array
    {
        $pdo = Database::getInstance();

        $sql = "
            SELECT 
                i.id,
                ti.nombre  AS tipo,
                ei.nombre  AS estado,
                pr.nivel   AS prioridad,
                i.descripcion,
                i.latitud,
                i.longitud,
                TO_CHAR(i.fecha_reporte,'YYYY-MM-DD') AS fecha_reporte
            FROM incidencia i
            JOIN tipo_incidencia    ti ON i.tipo_id      = ti.id
            JOIN estado_incidencia  ei ON i.estado_id    = ei.id
            LEFT JOIN prioridad     pr ON i.prioridad_id = pr.id
            ORDER BY i.fecha_reporte ASC
        ";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function asignarEmpleado(int $incidenciaId, int $empleadoId, int $prioridadId): bool
    {
        $pdo = Database::getInstance();
        $sql = "
        UPDATE incidencia
            SET asignado_a   = :empleado_id,
                prioridad_id = :prioridad_id
        WHERE id = :incidencia_id
        ";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'empleado_id'    => $empleadoId,
            'prioridad_id'   => $prioridadId,
            'incidencia_id'  => $incidenciaId
        ]);
    }

    public static function obtenerPorEmpleado(int $empleadoId): array
    {
        $pdo = Database::getInstance();

        $sql = "
            SELECT 
                i.id,
                i.foto,
                ti.nombre AS tipo,
                ei.nombre AS estado,
                pr.nivel   AS prioridad
                i.descripcion,
                i.latitud,
                i.longitud,
                TO_CHAR(i.fecha_reporte, 'YYYY-MM-DD') AS fecha_reporte
            FROM incidencia i
            INNER JOIN tipo_incidencia ti ON i.tipo_id = ti.id
            INNER JOIN estado_incidencia ei ON i.estado_id = ei.id
            WHERE i.asignado_a = :empleado_id
            ORDER BY i.fecha_reporte ASC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['empleado_id' => $empleadoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function actualizarEstado(int $incidenciaId, int $nuevoEstado): bool
    {
        $pdo = Database::getInstance();

        $sql = "UPDATE incidencia SET estado_id = :estado_id WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            'estado_id' => $nuevoEstado,
            'id' => $incidenciaId
        ]);
    }

    public static function validarTelefono(string $celular): array
    {
        $pdo = Database::getInstance();

        $sql = "SELECT id FROM ciudadano WHERE celular = :celular LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['celular' => $celular]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public static function registrarCiudadano(string $celular): int
    {
        $pdo = Database::getInstance();

        $sql = "INSERT INTO ciudadano (celular) VALUES (:celular) RETURNING id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['celular' => $celular]);

        return (int) $stmt->fetchColumn();
    }

    public static function obtenerPorCiudadano(int $idCelular): array
    {
        $pdo = Database::getInstance();

        $sql = "
            SELECT 
                i.id,
                ti.nombre AS tipo,
                ei.nombre AS estado,
                pr.nivel   AS prioridad
                i.descripcion,
                i.latitud,
                i.longitud,
                TO_CHAR(i.fecha_reporte, 'YYYY-MM-DD') AS fecha_reporte
            FROM incidencia i
            INNER JOIN tipo_incidencia ti ON i.tipo_id = ti.id
            INNER JOIN estado_incidencia ei ON i.estado_id = ei.id
            WHERE i.id_celular = :id_celular
            ORDER BY i.fecha_reporte ASC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_celular' => $idCelular]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}