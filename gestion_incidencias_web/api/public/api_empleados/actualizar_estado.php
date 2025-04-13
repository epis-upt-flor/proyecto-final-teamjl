<?php
require_once __DIR__ . '/../../bootstrap.php';

use App\Core\Response;
use App\Controllers\IncidenciaController;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::error("Método no permitido", 405);
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['incidencia_id'], $data['nuevo_estado'])) {
    Response::error("Datos incompletos", 422);
}

IncidenciaController::actualizarEstado($data);
