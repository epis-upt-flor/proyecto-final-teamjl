<?php
session_start();

// Verificar que se haya enviado el formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php?error=1");
    exit();
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validación básica
if (empty($email) || empty($password)) {
    header("Location: index.php?error=2");
    exit();
}

// Preparar los datos para enviar al API backend
$data = json_encode([
    'email' => $email,
    'password' => $password
]);

// Configurar la petición POST al API
$ch = curl_init('http://localhost:8080/proyecto-final-teamjl/gestion_incidencias_web/api/public/admin_login.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data)
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Decodificar la respuesta
$result = json_decode($response, true);

// Evaluar la respuesta
if ($http_code === 200 && isset($result['success']) && $result['success'] === true) {
    $_SESSION['admin_id'] = $result['data']['admin_id'];
    $_SESSION['admin_nombre'] = $result['data']['nombre'];
    $_SESSION['admin_token'] = $result['data']['token']; // Por si lo usas después

    header("Location: ../dashboard/index.php");
    exit();
} else {
    header("Location: index.php?error=3");
    exit();
}
