<?php
    require_once __DIR__ . '/../../bootstrap.php';

    use App\Core\Response;
    use App\Core\Database;

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        Response::error("Método no permitido", 405);
    }

    try {
        $pdo = Database::getInstance();

        $stmt1 = $pdo->query("
            SELECT ei.nombre AS estado, COUNT(*) AS total
            FROM incidencia i
            INNER JOIN estado_incidencia ei ON i.estado_id = ei.id
            GROUP BY ei.nombre
        ");
        $porEstado = $stmt1->fetchAll();

        $stmt2 = $pdo->query("
            SELECT ti.nombre AS tipo, COUNT(*) AS total
            FROM incidencia i
            INNER JOIN tipo_incidencia ti ON i.tipo_id = ti.id
            GROUP BY ti.nombre
        ");
        $porTipo = $stmt2->fetchAll();

        Response::success([
            'por_estado' => $porEstado,
            'por_tipo' => $porTipo
        ], "Resumen estadístico");
    } catch (Exception $e) {
        Response::error("Error al generar resumen: " . $e->getMessage(), 500);
    }
?>