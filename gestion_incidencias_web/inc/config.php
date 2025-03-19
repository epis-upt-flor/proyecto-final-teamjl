<?php
    // inc/config.php

    define('DB_HOST', 'localhost');
    define('DB_NAME', 'dbGestionJL');
    define('DB_USER', 'postgres');
    define('DB_PASSWORD', 'epis2025');
    define('DB_PORT', '5432');

    // Configuración general
    define('BASE_URL', 'http://localhost:8080/ProyectoGestiónIncidenciasV2/gestion_incidencias_web/api'); // URL base del proyecto

    // Configurar la zona horaria
    date_default_timezone_set('America/Lima');

    // Constantes para el manejo de login
    define('LOGIN_MAX_ATTEMPTS', 5);
    define('LOGIN_BLOCK_TIME', 600); // 10 minutos en segundos
?>