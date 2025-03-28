<?php
    require_once("../../inc/db.php");
    require_once("../../inc/config.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Verificar si ya hay un administrador con ese email
        $stmt = $pdo->prepare("SELECT id FROM administrador WHERE email = :email");
        $stmt->execute(['email' => $email]);
        
        if ($stmt->fetch()) {
            echo "Este correo ya está registrado.";
            exit();
        }

        // Insertar nuevo administrador
        $stmt = $pdo->prepare("INSERT INTO administrador (nombre, apellido, email, password) VALUES (:nombre, :apellido, :email, :password)");
        $stmt->execute([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'password' => $password
        ]);

        header("Location: login.php");
        exit();
    }
?>