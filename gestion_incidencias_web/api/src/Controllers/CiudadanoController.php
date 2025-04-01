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
                empty($data['tipo_incidencia_id']) ||
                empty($data['latitud']) ||
                empty($data['longitud']) ||
                empty($data['descripcion']) ||
                empty($data['foto_url'])
            ) {
                Response::error("Todos los campos son obligatorios", 422);
            }

            $tipo = $data['tipo_incidencia_id'];
            $lat = $data['latitud'];
            $lng = $data['longitud'];
            $descripcion = $data['descripcion'];
            $foto = $data['foto_url'];
            $fecha = date("Y-m-d");
            $hora = date("H:i:s");

            try {
                $pdo = Database::getInstance();

                $stmt = $pdo->prepare("
                    INSERT INTO incidencia (tipo_incidencia_id, latitud, longitud, descripcion, foto_url, fecha_reporte, hora_reporte, estado_id)
                    VALUES (:tipo, :lat, :lng, :descripcion, :foto, :fecha, :hora, 1) -- estado 1 = Pendiente
                ");
                $stmt->execute([
                    'tipo' => $tipo,
                    'lat' => $lat,
                    'lng' => $lng,
                    'descripcion' => $descripcion,
                    'foto' => $foto,
                    'fecha' => $fecha,
                    'hora' => $hora
                ]);

                Response::success([], "Incidencia reportada correctamente.");
            } catch (Exception $e) {
                Response::error("Error al registrar la incidencia: " . $e->getMessage(), 500);
            }
        }
    }
?>