<?php
header('Content-Type: application/json');
require_once '../inc/db.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_incidencia = trim($_POST['id_incidencia']);
    $id_empleado = trim($_POST['id_empleado']);
    $id_administrador = trim($_POST['id_administrador']);
    $prioridad = isset($_POST['prioridad']) ? trim($_POST['prioridad']) : 'media';
    $comentarios = isset($_POST['comentarios']) ? trim($_POST['comentarios']) : '';
    
    if(empty($id_incidencia) || empty($id_empleado) || empty($id_administrador)) {
        $response['success'] = false;
        $response['message'] = "Los campos id_incidencia, id_empleado y id_administrador son obligatorios.";
        echo json_encode($response);
        exit();
    }
    
    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("INSERT INTO asignaciones (id_incidencia, id_empleado, id_administrador, prioridad, comentarios) VALUES (:id_incidencia, :id_empleado, :id_administrador, :prioridad, :comentarios)");
    $stmt->bindParam(':id_incidencia', $id_incidencia);
    $stmt->bindParam(':id_empleado', $id_empleado);
    $stmt->bindParam(':id_administrador', $id_administrador);
    $stmt->bindParam(':prioridad', $prioridad);
    $stmt->bindParam(':comentarios', $comentarios);

    if($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Tarea asignada exitosamente.";
    } else {
        $response['success'] = false;
        $response['message'] = "Error al asignar la tarea.";
    }
    echo json_encode($response);
} else {
    echo json_encode(array('success' => false, 'message' => 'Método no permitido'));
}
?>
