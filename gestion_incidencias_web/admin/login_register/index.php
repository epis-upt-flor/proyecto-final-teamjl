<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: ../dashboard/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .error, .success {
            color: white;
            background-color: red;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
        }
        .success {
            background-color: green;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Administrador - Iniciar Sesión</h2>

    <div id="mensaje" class="error" style="display: none;"></div>

    <form id="loginForm">
        <input type="email" id="email" placeholder="Correo electrónico" required>
        <input type="password" id="password" placeholder="Contraseña" required>
        <input type="submit" value="Ingresar">
    </form>

    <a class="link" href="register.php">← ¿No tienes una cuenta? Regístrate ahora</a>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const mensajeDiv = document.getElementById('mensaje');
    mensajeDiv.style.display = 'none';

    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!email || !password) {
        mensajeDiv.textContent = "Correo y contraseña requeridos.";
        mensajeDiv.style.display = 'block';
        return;
    }

    try {
        const res = await fetch('http://localhost/proyecto-final-teamjl/gestion_incidencias_web/api/public/admin_login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });

        const data = await res.json();

        if (data.success) {
            // Guardar token en sessionStorage
            sessionStorage.setItem('admin_token', data.data.token);

            // Crear sesión PHP desde el cliente (opcional si usas session del lado del server)
            const phpSession = await fetch('crear_sesion_admin.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    admin_id: data.data.admin_id,
                    nombre: data.data.nombre,
                    token: data.data.token
                })
            });

            const resultadoSesion = await phpSession.json();

            if (resultadoSesion.success) {
                window.location.href = '../dashboard/index.php';
            } else {
                mensajeDiv.textContent = "Error creando sesión.";
                mensajeDiv.style.display = 'block';
            }

        } else {
            mensajeDiv.textContent = data.message || "Error en el inicio de sesión.";
            mensajeDiv.style.display = 'block';
        }
    } catch (err) {
        mensajeDiv.textContent = "Error de conexión con el servidor.";
        mensajeDiv.style.display = 'block';
    }
});
</script>
</body>
</html>