<?php
require_once __DIR__ . '/../../bootstrap.php';

use App\Core\Response;
use App\Controllers\IncidenciaController;

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Response::error("Método no permitido", 405);
}

if (!isset($_GET['empleado_id'])) {
    Response::error("ID del empleado requerido", 422);
}

$empleadoId = (int) $_GET['empleado_id'];

IncidenciaController::obtenerPorEmpleado($empleadoId);
