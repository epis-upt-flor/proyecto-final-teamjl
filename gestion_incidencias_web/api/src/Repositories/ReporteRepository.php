<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class ReporteRepository
{
    public static function contarPorEstado(): array
    {
        $pdo = Database::getInstance();
        $sql = "
                SELECT ei.nombre AS estado, COUNT(*) AS total
                FROM incidencia i
                INNER JOIN estado_incidencia ei ON i.estado_id = ei.id
                GROUP BY ei.nombre
            ";
        return $pdo->query($sql)->fetchAll();
    }

    public static function contarPorTipo(): array
    {
        $pdo = Database::getInstance();
        $sql = "
                SELECT ti.nombre AS tipo, COUNT(*) AS total
                FROM incidencia i
                INNER JOIN tipo_incidencia ti ON i.tipo_id = ti.id
                GROUP BY ti.nombre
            ";
        return $pdo->query($sql)->fetchAll();
    }

    public static function obtenerPorRango(string $inicio, string $fin): array
    {
        $pdo = Database::getInstance();
        $sql = "
            SELECT 
                i.id,
                ti.nombre AS tipo,
                ei.nombre AS estado,
                i.fecha_reporte
            FROM incidencia i
            INNER JOIN tipo_incidencia ti ON i.tipo_id = ti.id
            INNER JOIN estado_incidencia ei ON i.estado_id = ei.id
            WHERE i.fecha_reporte BETWEEN :inicio AND :fin
            ORDER BY i.fecha_reporte DESC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['inicio' => $inicio, 'fin' => $fin]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}