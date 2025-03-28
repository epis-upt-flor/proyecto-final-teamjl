<?php
    require_once("../../inc/db.php");
    require_once("../../inc/config.php");
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Verificar existencia
        $stmt = $pdo->prepare("SELECT * FROM administrador WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_nombre'] = $admin['nombre'];
            header("Location: ../dashboard/index.php");
            exit();
        } else {
            echo "Correo o contraseña incorrectos.";
            exit();
        }
    }
?>