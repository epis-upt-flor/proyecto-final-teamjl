<?php
require_once("../../inc/db.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

try {
    $stmt = $pdo->query("SELECT id, nombre FROM tipo_incidencia ORDER BY nombre");
    $tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'tipos' => $tipos]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error al obtener tipos: ' . $e->getMessage()]);
}
