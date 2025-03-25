<?php
    // inc/config.php

    // Parámetros de conexión actualizados para NeonTech PostgreSQL
    define('DB_HOST', 'ep-still-unit-a8b5odr0-pooler.eastus2.azure.neon.tech');            // Ejemplo: "neon-host.example.com"
    define('DB_NAME', 'dbgestionf');            // Nombre de la base de datos en NeonTech
    define('DB_USER', 'dbgestionf_owner');                // Usuario proporcionado por NeonTech
    define('DB_PASSWORD', 'npg_7zwC5akVZiox');         // Contraseña asignada
    define('DB_PORT', '5432');                           // Puerto (normalmente 5432)

    // Configuración general
    define('BASE_URL', 'http://localhost:8080/ProyectoGestiónIncidenciasV2/gestion_incidencias_web/api'); // URL base del proyecto

    // Configurar la zona horaria
    date_default_timezone_set('America/Lima');

    // Constantes para el manejo de login
    define('LOGIN_MAX_ATTEMPTS', 5);
    define('LOGIN_BLOCK_TIME', 600); // 10 minutos en segundos
?>
