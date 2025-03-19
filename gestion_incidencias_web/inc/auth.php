<?php
    // inc/auth.php

    // Inicia la sesión si aún no se ha iniciado
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    /**
     * Verifica si un administrador ha iniciado sesión.
     * @return bool
     */
    function isAdminLoggedIn() {
        return isset($_SESSION['admin_id']);
    }

    /**
     * Requiere que el administrador esté logueado.
     * Si no lo está, redirige a login.php.
     */
    function requireAdminLogin() {
        if (!isAdminLoggedIn()) {
            header("Location: login.php");
            exit();
        }
    }

    /**
     * Verifica si un usuario (ciudadano o empleado) ha iniciado sesión.
     * @return bool
     */
    function isUserLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Requiere que el usuario (ciudadano o empleado) esté logueado.
     * Si no lo está, redirige a la página de login correspondiente.
     */
    function requireUserLogin() {
        if (!isUserLoggedIn()) {
            header("Location: login.php");
            exit();
        }
    }
?>