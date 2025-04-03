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
            empty($data['tipo']) ||
            empty($data['latitud']) ||
            empty($data['longitud']) ||
            empty($data['descripcion']) ||
            empty($data['foto'])
        ) {
            Response::error("Todos los campos son obligatorios", 422);
        }

       
        $tipo = $data['tipo'];
        $lat = $data['latitud'];
        $lng = $data['longitud'];
        $descripcion = $data['descripcion'];
        $foto = $data['foto'];
        $fecha = date("Y-m-d H:i:s");

        try {
            $pdo = Database::getInstance();

            $stmt = $pdo->prepare("
                INSERT INTO incidencia (
                    tipo, descripcion, foto, latitud, longitud, fecha_reporte, estado_id
                ) VALUES (
                    :tipo, :descripcion, :foto, :lat, :lng, :fecha, 1
                )
            ");

            $stmt->execute([
                'tipo' => $tipo,
                'descripcion' => $descripcion,
                'foto' => $foto,
                'lat' => $lat,
                'lng' => $lng,
                'fecha' => $fecha
            ]);

            Response::success([], "Incidencia reportada correctamente.");
        } catch (Exception $e) {
            Response::error("Error al registrar la incidencia: " . $e->getMessage(), 500);
        }
    }
}
