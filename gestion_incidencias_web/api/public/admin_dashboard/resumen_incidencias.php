<?php
    require_once __DIR__ . '/../../bootstrap.php';

    use App\Core\Response;
    use App\Core\Database;

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        Response::error("Método no permitido", 405);
    }

    try {
        $pdo = Database::getInstance();

        $stmt = $pdo->query("
            SELECT ei.nombre AS estado, COUNT(*) AS total
            FROM incidencia i
            INNER JOIN estado_incidencia ei ON i.estado_id = ei.id
            GROUP BY ei.nombre
        ");

        $resumen = [
            'Pendiente' => 0,
            'En Desarrollo' => 0,
            'Terminado' => 0
        ];

        while ($row = $stmt->fetch()) {
            $estado = $row['estado'];
            $resumen[$estado] = (int) $row['total'];
        }

        Response::success($resumen, "Resumen de incidencias");
    } catch (Exception $e) {
        Response::error("Error al cargar resumen: " . $e->getMessage(), 500);
    }
?>