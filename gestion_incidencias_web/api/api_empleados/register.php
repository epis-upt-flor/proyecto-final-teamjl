<?php
require_once("../../inc/db.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

$dni = $_POST['dni'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$dni || !$nombre || !$apellido || !$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Campos incompletos']);
    exit();
}

try {
    // Verificar si ya existe
    $check = $pdo->prepare("SELECT id FROM empleado WHERE dni = :dni OR email = :email");
    $check->execute(['dni' => $dni, 'email' => $email]);

    if ($check->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Ya existe un empleado con ese DNI o correo']);
        exit();
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO empleado (dni, nombre, apellido, email, password) VALUES (:dni, :nombre, :apellido, :email, :password)");
    $stmt->execute([
        'dni' => $dni,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'email' => $email,
        'password' => $hash
    ]);

    echo json_encode(['success' => true, 'message' => 'Empleado registrado correctamente']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error al registrar: ' . $e->getMessage()]);
}
