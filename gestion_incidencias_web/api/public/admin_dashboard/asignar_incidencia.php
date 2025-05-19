<?php
    require_once __DIR__ . '/../../bootstrap.php';

    use App\Controllers\IncidenciaController;
    use App\Core\Response;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        Response::error("Método no permitido", 405);
    }

    $data = json_decode(file_get_contents("php://input"), true);

    if (
        !isset($data['incidencia_id']) ||
        !isset($data['empleado_id']) ||
        !isset($data['prioridad_id'])
    ) {
        Response::error("Faltan datos", 422);
    }

    IncidenciaController::asignarEmpleado($data);
?>