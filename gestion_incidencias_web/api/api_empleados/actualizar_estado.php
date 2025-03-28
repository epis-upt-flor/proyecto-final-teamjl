<?php
require_once("../../inc/db.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$token = $_POST['token'] ?? '';
$incidencia_id = $_POST['incidencia_id'] ?? null;
$nuevo_estado = $_POST['estado_id'] ?? null;

if (!$token || !$incidencia_id || !$nuevo_estado) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit();
}

// Verificar token
$stmt = $pdo->prepare("SELECT empleado_id FROM empleado_token WHERE token = :token");
$stmt->execute(['token' => $token]);
$empleado = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$empleado) {
    echo json_encode(['success' => false, 'message' => 'Token inválido']);
    exit();
}

$empleado_id = $empleado['empleado_id'];

// Actualizar estado
try {
    $stmt = $pdo->prepare("UPDATE incidencia SET estado_id = :estado WHERE id = :id AND asignado_a = :empleado");
    $stmt->execute([
        'estado' => $nuevo_estado,
        'id' => $incidencia_id,
        'empleado' => $empleado_id
    ]);

    // Agregar al historial de cambios
    $hist = $pdo->prepare("INSERT INTO historial_estado (incidencia_id, estado_id, empleado_id) VALUES (:id, :estado, :empleado)");
    $hist->execute([
        'id' => $incidencia_id,
        'estado' => $nuevo_estado,
        'empleado' => $empleado_id
    ]);

    echo json_encode(['success' => true, 'message' => 'Estado actualizado']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . $e->getMessage()]);
}
