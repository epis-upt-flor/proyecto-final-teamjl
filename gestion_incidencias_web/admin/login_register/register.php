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
    <title>Registro de Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .message {
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
        .message.success {
            background: #d4edda;
            color: #155724;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .link {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="register-box">
    <h2>Registrar Administrador</h2>

    <div id="mensaje" class="message" style="display: none;"></div>

    <form id="registerForm">
        <input type="text" id="nombre" placeholder="Nombre completo" required>
        <input type="text" id="apellido" placeholder="Apellido" required>
        <input type="email" id="email" placeholder="Correo electrónico" required>
        <input type="password" id="password" placeholder="Contraseña" required>
        <input type="submit" value="Registrar">
    </form>

    <a class="link" href="index.php">← Volver al login</a>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const mensajeDiv = document.getElementById('mensaje');
    mensajeDiv.style.display = 'none';
    mensajeDiv.classList.remove('error', 'success');

    const nombre = document.getElementById('nombre').value.trim();
    const apellido = document.getElementById('apellido').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!nombre || !apellido || !email || !password) {
        mensajeDiv.textContent = 'Todos los campos son obligatorios.';
        mensajeDiv.classList.add('error');
        mensajeDiv.style.display = 'block';
        return;
    }

    try {
        const res = await fetch('http://localhost/proyecto-final-teamjl/gestion_incidencias_web/api/public/admin_register.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre, apellido, email, password })
        });

        const data = await res.json();

        if (data.success) {
            mensajeDiv.textContent = '✅ Registro exitoso. Ya puedes iniciar sesión.';
            mensajeDiv.classList.add('success');
        } else {
            mensajeDiv.textContent = data.message || 'Error desconocido.';
            mensajeDiv.classList.add('error');
        }

        mensajeDiv.style.display = 'block';
    } catch (error) {
        mensajeDiv.textContent = 'Error de conexión con el servidor.';
        mensajeDiv.classList.add('error');
        mensajeDiv.style.display = 'block';
    }
});
</script>
</body>
</html>
