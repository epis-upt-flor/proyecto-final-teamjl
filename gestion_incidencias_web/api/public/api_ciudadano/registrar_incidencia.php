<?php
    require_once __DIR__ . '/../../bootstrap.php';

    use App\Controllers\CiudadanoController;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        \App\Core\Response::error("Método no permitido", 405);
    }

    $data = json_decode(file_get_contents("php://input"), true);
    CiudadanoController::registrarIncidencia($data);
?>