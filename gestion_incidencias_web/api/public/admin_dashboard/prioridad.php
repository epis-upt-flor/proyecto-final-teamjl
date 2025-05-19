<?php
require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\PrioridadController;

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    \App\Core\Response::error("Método no permitido", 405);
}

PrioridadController::listar();
