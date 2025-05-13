<?php
    namespace App\Controllers;

    use App\Core\Response;
    use App\Core\Database;
    use Exception;

    class CiudadanoController
    {
        public static function registrarIncidencia(array $data): void
        {
            if (
                empty($data['tipo_id']) ||
                empty($data['latitud']) ||
                empty($data['longitud']) ||
                empty($data['descripcion'])
            ) {
                Response::error("Todos los campos son obligatorios", 422);
            }

            $tipo_id = $data['tipo_id'];
            $lat = $data['latitud'];
            $lng = $data['longitud'];
            $descripcion = $data['descripcion'];
            $fecha = date("Y-m-d H:i:s");
            $zona = $data['zona'] ?? 'Zona no disponible';

            $foto = null;
            if (!empty($data['foto'])) {
                $foto = base64_decode($data['foto']);
            }

            try {
                $pdo = Database::getInstance();

                $stmt = $pdo->prepare("
                    INSERT INTO incidencia (
                        tipo_id, descripcion, foto, latitud, longitud, fecha_reporte, estado_id, zona
                    ) VALUES (
                        :tipo_id, :descripcion, :foto, :lat, :lng, :fecha, 1, :zona
                    )
                ");

                $stmt->bindParam(':tipo_id', $tipo_id, \PDO::PARAM_INT);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':foto', $foto, \PDO::PARAM_LOB);
                $stmt->bindParam(':lat', $lat);
                $stmt->bindParam(':lng', $lng);
                $stmt->bindParam(':fecha', $fecha);
                $stmt->bindParam(':zona', $zona);

                $stmt->execute();

                Response::success([], "Incidencia reportada correctamente.");
            } catch (Exception $e) {
                Response::error("Error al registrar la incidencia: " . $e->getMessage(), 500);
            }
        }

        public static function obtenerTiposIncidencia(): void
        {
            try {
                $pdo = Database::getInstance();
                $stmt = $pdo->query("SELECT id, nombre FROM tipo_incidencia ORDER BY nombre ASC");
                $tipos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                Response::json($tipos);
            } catch (Exception $e) {
                Response::error("Error al obtener tipos de incidencia: " . $e->getMessage(), 500);
            }
        }

        public static function obtenerHistorialIncidencias(): void
        {
            try {

                $incidencias = \App\Repositories\IncidenciaRepository::obtenerTodas();
                Response::success($incidencias, "Historial de incidencias");
            } catch (Exception $e) {
                Response::error("Error al obtener historial de incidencias: " . $e->getMessage(), 500);
            }
        }
    }
?>