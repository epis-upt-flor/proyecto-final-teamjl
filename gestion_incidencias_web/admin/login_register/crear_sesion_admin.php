<?php
session_start();
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

if (
    isset($input['admin_id']) &&
    isset($input['nombre']) &&
    isset($input['token'])
) {
    $_SESSION['admin_id'] = $input['admin_id'];
    $_SESSION['admin_nombre'] = $input['nombre'];
    $_SESSION['admin_token'] = $input['token'];

    echo json_encode(['success' => true]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos para la sesión de administrador.'
    ]);
}