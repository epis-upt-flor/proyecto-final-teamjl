<?php
require_once("../../inc/db.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$token = $_GET['token'] ?? '';

if (!$token) {
    echo json_encode(['success' => false, 'message' => 'Token requerido']);
    exit();
}

$stmt = $pdo->prepare("SELECT empleado_id FROM empleado_token WHERE token = :token");
$stmt->execute(['token' => $token]);
$empleado = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$empleado) {
    echo json_encode(['success' => false, 'message' => 'Token inválido']);
    exit();
}

$empleado_id = $empleado['empleado_id'];

$stmt = $pdo->prepare("
    SELECT i.id, ti.nombre AS tipo, i.descripcion, i.latitud, i.longitud, ei.nombre AS estado
    FROM incidencia i
    JOIN tipo_incidencia ti ON i.tipo_id = ti.id
    JOIN estado_incidencia ei ON i.estado_id = ei.id
    WHERE i.asignado_a = :id
    ORDER BY i.fecha_reporte DESC
");
$stmt->execute(['id' => $empleado_id]);
$incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'incidencias' => $incidencias]);
