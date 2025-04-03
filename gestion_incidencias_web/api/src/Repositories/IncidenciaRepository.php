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
                i.tipo,
                ei.nombre AS estado,
                i.descripcion,
                i.latitud,
                i.longitud,
                TO_CHAR(i.fecha_reporte, 'YYYY-MM-DD') AS fecha_reporte
            FROM incidencia i
            INNER JOIN estado_incidencia ei ON i.estado_id = ei.id
            ORDER BY i.fecha_reporte DESC
        ";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
