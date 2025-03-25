<?php
require_once '../inc/auth.php';
requireAdminLogin();
require_once '../inc/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = intval($_POST['id_usuario']);
    $nuevo_estado = trim($_POST['nuevo_estado']);

    if (!in_array($nuevo_estado, ['activo', 'inactivo'])) {
        die("Estado inválido.");
    }

    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("UPDATE empleados SET estado = :estado WHERE id_usuario = :id_usuario");
    $stmt->bindParam(':estado', $nuevo_estado);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: empleados.php?success=1");
    } else {
        echo "Error al actualizar el estado.";
    }
} else {
    echo "Acceso no permitido.";
}
