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
                    ti.nombre AS tipo,
                    ei.nombre AS estado,
                    i.descripcion,
                    i.latitud,
                    i.longitud,
                    TO_CHAR(i.fecha_reporte, 'YYYY-MM-DD') AS fecha_reporte
                FROM incidencia i
                INNER JOIN tipo_incidencia ti ON i.tipo_id = ti.id
                INNER JOIN estado_incidencia ei ON i.estado_id = ei.id
                ORDER BY i.fecha_reporte ASC
            ";

            $stmt = $pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function asignarEmpleado(int $incidenciaId, int $empleadoId): bool
        {
            $pdo = Database::getInstance();
        
            $stmt = $pdo->prepare("UPDATE incidencia SET asignado_a = :empleado_id WHERE id = :incidencia_id");
        
            return $stmt->execute([
                'empleado_id' => $empleadoId,
                'incidencia_id' => $incidenciaId
            ]);
        }

        public static function obtenerPorEmpleado(int $empleadoId): array
        {
            $pdo = Database::getInstance();

            $sql = "
                SELECT 
                    i.id,
                    ti.nombre AS tipo,
                    ei.nombre AS estado,
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
    }
?>