<?php
    header('Content-Type: application/json');
    require_once '../inc/db.php';

    $response = array();
    $db = new Database();
    $conn = $db->connect();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['id_usuario']) && !empty($_GET['id_usuario'])) {
            $id_usuario = trim($_GET['id_usuario']);
            $stmt = $conn->prepare("SELECT * FROM incidencias WHERE id_usuario = :id_usuario ORDER BY fecha_reporte DESC");
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        } else {
            $stmt = $conn->prepare("SELECT * FROM incidencias ORDER BY fecha_reporte DESC");
        }

        $stmt->execute();
        $incidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($incidencias) {
            $response['success'] = true;
            $response['data'] = $incidencias;
        } else {
            $response['success'] = false;
            $response['message'] = "No se encontraron incidencias.";
        }
        echo json_encode($response);
    } else {
        echo json_encode(array('success' => false, 'message' => 'Método no permitido'));
    }
?>