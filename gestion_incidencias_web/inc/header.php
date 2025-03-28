<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Incidencias</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        nav {
            background-color: #343a40;
            padding: 15px;
            color: white;
        }

        nav a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #dee2e6;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f1f1f1;
        }

        button, input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover, input[type="submit"]:hover {
            background-color: #0056b3;
        }

        input, select, textarea {
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<nav>
    <span>👤 Administrador: <?php echo htmlspecialchars($_SESSION['admin_nombre'] ?? ''); ?></span>
    |
    <a href="<?php echo BASE_URL; ?>../admin/dashboard/index.php">Dashboard</a>
    <a href="<?php echo BASE_URL; ?>../admin/incidencias/index.php">Incidencias</a>
    <a href="<?php echo BASE_URL; ?>../admin/incidencias/calendario.php">Calendario</a>
    <a href="<?php echo BASE_URL; ?>../admin/empleados/index.php">Empleados</a>
    <a href="<?php echo BASE_URL; ?>../admin/reporte/index.php">Reportes</a>
    <a href="<?php echo BASE_URL; ?>../admin/login_register/logout.php">Cerrar sesión</a>
</nav>
<div class="container">