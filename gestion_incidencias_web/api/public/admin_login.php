<?php
# Instanciar bootstrap (autoload + .env + Auth)
require_once __DIR__ . '/../bootstrap.php';

# Usar el controlador del administrador
use App\Controllers\AdminController;
use App\Core\Response;

# Verificar que sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::error("Método no permitido", 405);
}

# Obtener y decodificar el cuerpo JSON
$data = json_decode(file_get_contents("php://input"), true);

# Validar que los campos estén presentes
if (!isset($data['email']) || !isset($data['password'])) {
    Response::error("Email y contraseña requeridos", 422);
}

# Ejecutar el login (la función ya imprime la respuesta y termina el script)
AdminController::login($data['email'], $data['password']);