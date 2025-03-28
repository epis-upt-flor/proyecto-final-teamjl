<?php
require_once("../../inc/db.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

try {
    $stmt = $pdo->prepare("SELECT * FROM empleado WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$empleado || !password_verify($password, $empleado['password'])) {
        echo json_encode(['success' => false, 'message' => 'Credenciales inválidas']);
        exit();
    }

    $token = bin2hex(random_bytes(16));

    // Guardar el token
    $stmt = $pdo->prepare("INSERT INTO empleado_token (empleado_id, token) VALUES (:id, :token)");
    $stmt->execute([
        'id' => $empleado['id'],
        'token' => $token
    ]);

    echo json_encode([
        'success' => true,
        'token' => $token,
        'empleado_id' => $empleado['id'],
        'nombre' => $empleado['nombre']
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
