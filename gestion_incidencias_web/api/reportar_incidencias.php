<?php
header('Content-Type: application/json');
require_once '../inc/db.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = trim($_POST['id_usuario']);
    $tipo = trim($_POST['tipo']);
    $descripcion = trim($_POST['descripcion']);
    $foto = trim($_POST['foto']);
    $latitud = trim($_POST['latitud']);
    $longitud = trim($_POST['longitud']);
    $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';

    if(empty($id_usuario) || empty($tipo) || empty($descripcion) || empty($foto) || empty($latitud) || empty($longitud)) {
        $response['success'] = false;
        $response['message'] = "Todos los campos obligatorios deben estar presentes.";
        echo json_encode($response);
        exit();
    }

    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("INSERT INTO incidencias (id_usuario, tipo, descripcion, foto, latitud, longitud, direccion) VALUES (:id_usuario, :tipo, :descripcion, :foto, :latitud, :longitud, :direccion)");
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':foto', $foto);
    $stmt->bindParam(':latitud', $latitud);
    $stmt->bindParam(':longitud', $longitud);
    $stmt->bindParam(':direccion', $direccion);

    if($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Incidencia reportada exitosamente.";
    } else {
        $response['success'] = false;
        $response['message'] = "Error al reportar la incidencia.";
    }
    echo json_encode($response);
} else {
    echo json_encode(array('success' => false, 'message' => 'Método no permitido'));
}
?>
