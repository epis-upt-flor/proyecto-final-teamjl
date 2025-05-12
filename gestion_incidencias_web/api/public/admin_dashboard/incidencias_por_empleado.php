<?php
// api/public/admin_dashboard/incidencias_por_empleado.php

require_once __DIR__ . '/../../bootstrap.php';

use App\Core\Response;
use App\Core\Database;
use App\Repositories\IncidenciaRepository;

// 1) Sólo GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Response::error('Método no permitido', 405);
    exit;
}

try {
    // 2) Obtener todos los empleados
    $pdo = Database::getInstance();
    $stmtEmp = $pdo->query("
        SELECT id, nombre || ' ' || apellido AS nombre_completo
        FROM empleado
        ORDER BY apellido, nombre
    ");
    $empleados = $stmtEmp->fetchAll(\PDO::FETCH_ASSOC);

    // 3) Para cada empleado, obtener sus incidencias
    $data = [];
    foreach ($empleados as $emp) {
        $incidencias = IncidenciaRepository::obtenerPorEmpleado((int)$emp['id']);
        $data[] = [
            'empleado_id' => $emp['id'],
            'empleado'    => $emp['nombre_completo'],
            'incidencias' => $incidencias
        ];
    }

    // 4) Responder JSON
    Response::success($data, 'Incidencias agrupadas por empleado obtenidas correctamente');
} catch (\Exception $e) {
    Response::error('Error obteniendo incidencias por empleado: ' . $e->getMessage());
}
