<?php
    require_once __DIR__ . '/../../bootstrap.php';

    use App\Core\Auth;
    use App\Core\Response;
    use App\Controllers\ReporteController;

    // —————————————————————————————————————————————
    // 1) Verificar token Bearer
    $hdr = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!preg_match('/^Bearer\s+(.+)$/', $hdr, $m)) {
        Response::error("Token requerido", 401);
    }
    try {
        $user = Auth::verificarToken($m[1]);
    } catch (\Exception $e) {
        Response::error("Token inválido", 401);
    }
    // 2) Solo administradores
    if (($user['role'] ?? '') !== 'administrador') {
        Response::error("Permiso denegado", 403);
    }
    // —————————————————————————————————————————————

    ReporteController::estadisticas();
?>