<?php
    require_once __DIR__ . '/../bootstrap.php';

    use App\Controllers\AdminController;
    use App\Core\Response;

    // Verificar método
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        \App\Core\Response::error("Método no permitido", 405);
    }

    // Obtener datos
    $data = json_decode(file_get_contents("php://input"), true);

    // Ejecutar registro
    AdminController::register($data);
?>