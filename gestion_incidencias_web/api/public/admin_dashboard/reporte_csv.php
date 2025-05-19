<?php
require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\ReporteController;
use App\Core\Response;

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Response::error('Método no permitido', 405);
}

ReporteController::exportCsv();
?>