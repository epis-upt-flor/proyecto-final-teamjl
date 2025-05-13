<?php
require_once __DIR__ . '/../../bootstrap.php';

use App\Core\Response;
use App\Controllers\CiudadanoController;

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Response::error("Método no permitido", 405);
}

CiudadanoController::obtenerHistorialIncidencias();
?>
