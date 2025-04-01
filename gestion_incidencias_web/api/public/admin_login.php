<?php
require_once __DIR__ . '/../bootstrap.php';

use App\Controllers\AdminController;
use App\Core\Response;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::error("Método no permitido", 405);
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['password'])) {
    Response::error("Email y contraseña requeridos", 422);
}

AdminController::login($data['email'], $data['password']);