<?php
require_once("../../inc/db.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Validar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

// Recoger datos enviados
$tipo_id      = $_POST['tipo_id'] ?? null;
$descripcion  = $_POST['descripcion'] ?? '';
$latitud      = $_POST['latitud'] ?? null;
$longitud     = $_POST['longitud'] ?? null;
$direccion    = $_POST['direccion'] ?? null;
$foto_base64  = $_POST['foto'] ?? null;

if (!$tipo_id || !$latitud || !$longitud || !$descripcion) {
    echo json_encode(['success' => false, 'message' => 'Faltan campos obligatorios']);
    exit();
}

try {
    $foto_binario = null;
    if ($foto_base64) {
        $foto_binario = base64_decode($foto_base64);
    }

    $stmt = $pdo->prepare("
        INSERT INTO incidencia (tipo_id, descripcion, foto, latitud, longitud, direccion, fecha_reporte)
        VALUES (:tipo_id, :descripcion, :foto, :latitud, :longitud, :direccion, NOW())
    ");

    $stmt->execute([
        'tipo_id' => $tipo_id,
        'descripcion' => $descripcion,
        'foto' => $foto_binario,
        'latitud' => $latitud,
        'longitud' => $longitud,
        'direccion' => $direccion
    ]);

    echo json_encode(['success' => true, 'message' => 'Incidencia registrada correctamente']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error al registrar incidencia: ' . $e->getMessage()]);
}
