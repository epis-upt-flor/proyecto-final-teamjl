<?php
    namespace App\Repositories;

    use App\Core\Database;
    use PDO;

    class CalendarioRepository
    {
        public static function guardarFecha(int $incidenciaId, string $fecha): bool
        {
            $pdo = Database::getInstance();

            // Verificar si ya existe
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM calendario_incidencia WHERE id_incidencia = :id");
            $stmt->execute(['id' => $incidenciaId]);
            $existe = $stmt->fetchColumn() > 0;

            if ($existe) {
                $sql = "UPDATE calendario_incidencia SET fecha_programada = :fecha WHERE id_incidencia = :id";
            } else {
                $sql = "INSERT INTO calendario_incidencia (id_incidencia, fecha_programada) VALUES (:id, :fecha)";
            }

            $stmt = $pdo->prepare($sql);
            return $stmt->execute(['id' => $incidenciaId, 'fecha' => $fecha]);
        }
    }
?>