<?php
require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\ReporteController;
use App\Core\Response;

// Sólo GET permitido
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Response::error('Método no permitido', 405);
}

// Dispara la exportCsv
ReporteController::exportCsv();
