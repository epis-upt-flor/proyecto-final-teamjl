<?php
    namespace App\Repositories;

    use App\Core\Database;

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
    }
?>