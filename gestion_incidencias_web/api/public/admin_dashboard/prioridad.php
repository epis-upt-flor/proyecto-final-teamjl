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
            SELECT id, nivel AS prioridad
            FROM prioridad
            ORDER BY nivel DESC
        ");
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        Response::success($data, "Prioridades obtenidas correctamente");
    } catch (\Exception $e) {
        Response::error("Error al obtener prioridades: " . $e->getMessage(), 500);
    }
?>