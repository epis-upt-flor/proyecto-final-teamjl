<?php
    session_start();
    if (isset($_SESSION['admin_id'])) {
        header("Location: ../dashboard/index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro Administrador</title>
</head>
<body>
    <h2>Registrar Administrador</h2>
    <form action="procesar_register.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <input type="text" name="apellido" placeholder="Apellido" required><br>
        <input type="email" name="email" placeholder="Correo" required><br>
        <input type="password" name="password" placeholder="Contraseña" required><br>
        <button type="submit">Registrar</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
</body>
</html>