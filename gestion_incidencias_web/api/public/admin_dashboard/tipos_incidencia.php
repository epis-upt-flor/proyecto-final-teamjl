<?php
    require_once __DIR__ . '/../../bootstrap.php';

    use App\Core\Response;
    use App\Core\Database;

    try {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT id, nombre FROM tipo_incidencia ORDER BY nombre ASC");
        $tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        Response::success($tipos, "Tipos de incidencia obtenidos correctamente");
    } catch (Exception $e) {
        Response::error("Error al obtener tipos de incidencia: " . $e->getMessage());
    }
?>