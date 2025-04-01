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
            SELECT 
                i.id,
                ti.nombre AS tipo,
                ei.nombre AS estado,
                i.descripcion,
                i.latitud,
                i.longitud,
                i.fecha_reporte
            FROM incidencia i
            INNER JOIN tipo_incidencia ti ON i.tipo_id = ti.id
            INNER JOIN estado_incidencia ei ON i.estado_id = ei.id
            ORDER BY i.fecha_reporte DESC
        ");
    
        $incidencias = $stmt->fetchAll();
    
        Response::success($incidencias, "Listado de incidencias");
    } catch (Exception $e) {
        Response::error("Error al cargar incidencias: " . $e->getMessage(), 500);
    }
?>