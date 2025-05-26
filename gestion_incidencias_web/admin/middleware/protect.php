<?php
    // Rutas públicas
    if (in_array($_GET['path'] ?? '', ['auth/login','auth/register'])) {
        return;
    }

    // Si no hay usuario logueado
    if (empty($_SESSION['user_id'])) {
        header('Location: ' . url('auth/login'));
        exit;
    }

    // Si soy empleado y trato de entrar a un área de admin, lo redirijo:
    $role = $_SESSION['user_role'] ?? '';
    $path = explode('/', ($_GET['path'] ?? 'dashboard'))[0];

    if ($role === 'empleado' && in_array($path, ['dashboard','empleados','reporte'])) {
        header('Location: ' . url('incidencias'));
        exit;
    }
?>