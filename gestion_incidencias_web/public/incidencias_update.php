<?php
require_once '../inc/auth.php';
requireAdminLogin();
require_once '../inc/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id_incidencia']);
    $nuevo_estado = trim($_POST['nuevo_estado']);

    $estados_validos = ['pendiente', 'validado', 'en proceso', 'resuelto', 'rechazado'];

    if (!in_array($nuevo_estado, $estados_validos)) {
        die("Estado inválido.");
    }

    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("UPDATE incidencias SET estado = :estado, ultima_actualizacion = NOW() WHERE id = :id");
    $stmt->bindParam(':estado', $nuevo_estado);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: incidencias.php?success=1");
    } else {
        echo "Error al actualizar el estado.";
    }
} else {
    echo "Acceso no permitido.";
}
