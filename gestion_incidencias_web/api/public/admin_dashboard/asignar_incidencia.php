<?php
    require_once __DIR__ . '/../../bootstrap.php';

    use App\Core\Auth;
    use App\Core\Response;
    use App\Controllers\IncidenciaController;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        Response::error("Método no permitido", 405);
    }

    // 2) Verificar token Bearer
    $hdr = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!preg_match('/^Bearer\s+(.+)$/', $hdr, $m)) {
        Response::error("Token requerido", 401);
    }
    try {
        $user = Auth::verificarToken($m[1]);
    } catch (\Exception $e) {
        Response::error("Token inválido", 401);
    }

    // 3) Solo administradores pueden asignar/priorizar
    if (!in_array($user['role'] ?? '', ['administrador'])) {
        Response::error("Permiso denegado", 403);
    }

    // 4) Leer y validar payload
    $data = json_decode(file_get_contents("php://input"), true);
    if (
        !isset($data['incidencia_id']) ||
        !isset($data['empleado_id'])   ||
        !isset($data['prioridad_id'])
    ) {
        Response::error("Faltan datos", 422);
    }

    // 5) Ejecutar asignación
    IncidenciaController::asignarEmpleado($data);
?>