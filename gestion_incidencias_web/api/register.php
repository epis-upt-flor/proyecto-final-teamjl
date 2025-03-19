<?php
header('Content-Type: application/json');
require_once '../inc/db.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);
    $rol = trim($_POST['rol']);

    if(empty($nombre) || empty($correo) || empty($password) || empty($rol)) {
        $response['success'] = false;
        $response['message'] = "Todos los campos son obligatorios.";
        echo json_encode($response);
        exit();
    }
    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $response['success'] = false;
        $response['message'] = "El correo no es válido.";
        echo json_encode($response);
        exit();
    }
    if($rol != 'ciudadano' && $rol != 'empleado') {
        $response['success'] = false;
        $response['message'] = "El rol debe ser 'ciudadano' o 'empleado'.";
        echo json_encode($response);
        exit();
    }

    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = :correo");
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->execute();
    if($stmt->fetch(PDO::FETCH_ASSOC)) {
        $response['success'] = false;
        $response['message'] = "El correo ya está registrado.";
        echo json_encode($response);
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, password, rol, confirmado) VALUES (:nombre, :correo, :password, :rol, false)");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':rol', $rol);

    if($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Registro exitoso. Revisa tu correo para confirmar la cuenta.";
    } else {
        $response['success'] = false;
        $response['message'] = "Error al registrar, inténtalo de nuevo.";
    }
    echo json_encode($response);
} else {
    echo json_encode(array('success' => false, 'message' => 'Método no permitido'));
}
?>
