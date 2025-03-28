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
    <title>Login Administrador</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form action="procesar_login.php" method="POST">
        <input type="email" name="email" placeholder="Correo" required><br>
        <input type="password" name="password" placeholder="Contraseña" required><br>
        <button type="submit">Ingresar</button>
    </form>
    <p>¿Aún no tienes cuenta? <a href="register.php">Regístrate</a></p>
</body>
</html>