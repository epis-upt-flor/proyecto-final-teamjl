<?php
header('Content-Type: application/json');
require_once '../inc/db.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);

    if(empty($correo) || empty($password)) {
        $response['success'] = false;
        $response['message'] = "Por favor, completa todos los campos.";
        echo json_encode($response);
        exit();
    }

    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("SELECT id, nombre, correo, password, rol, confirmado FROM usuarios WHERE correo = :correo LIMIT 1");
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user) {
        if(password_verify($password, $user['password'])) {
            if(!$user['confirmado']) {
                $response['success'] = false;
                $response['message'] = "Cuenta no confirmada. Revisa tu correo.";
            } else {
                $response['success'] = true;
                $response['message'] = "Inicio de sesión exitoso.";
                $response['data'] = array(
                    'id' => $user['id'],
                    'nombre' => $user['nombre'],
                    'correo' => $user['correo'],
                    'rol' => $user['rol']
                );
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Correo o password incorrectos.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Correo o password incorrectos.";
    }
    echo json_encode($response);
} else {
    echo json_encode(array('success' => false, 'message' => 'Método no permitido'));
}
?>
