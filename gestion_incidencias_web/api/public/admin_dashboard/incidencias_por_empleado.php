<?php
    require_once __DIR__ . '/../../bootstrap.php';

    use App\Core\Auth;
    use App\Core\Response;
    use App\Core\Database;
    use App\Repositories\IncidenciaRepository;

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
    if (($user['rol'] ?? '') !== 'administrador') {
        Response::error("Permiso denegado", 403);
    }
    // —————————————————————————————————————————————

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        Response::error('Método no permitido', 405);
    }

    try {
        $pdo = Database::getInstance();
        $stmtEmp = $pdo->query("
            SELECT id, nombre || ' ' || apellido AS nombre_completo
            FROM empleado
            ORDER BY apellido, nombre
        ");
        $empleados = $stmtEmp->fetchAll(\PDO::FETCH_ASSOC);

        $data = [];
        foreach ($empleados as $emp) {
            $incidencias = IncidenciaRepository::obtenerPorEmpleado((int)$emp['id']);
            $data[] = [
                'empleado_id' => $emp['id'],
                'empleado'    => $emp['nombre_completo'],
                'incidencias' => $incidencias
            ];
        }

        Response::success($data, 'Incidencias agrupadas por empleado obtenidas correctamente');
    } catch (\Exception $e) {
        Response::error('Error obteniendo incidencias por empleado: ' . $e->getMessage());
    }
?>