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
            SELECT id, dni, nombre, apellido, email
            FROM empleado
            ORDER BY apellido ASC, nombre ASC
        ");

        $empleados = $stmt->fetchAll();

        Response::success($empleados, "Lista de empleados");
    } catch (Exception $e) {
        Response::error("Error al obtener empleados: " . $e->getMessage(), 500);
    }
?>