<?php
    #Primero instanciamos el autoload de las clases gracias a Composer
    require_once __DIR__ . '/../vendor/autoload.php';

    #Luego cargamos las variables del entorno
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    #Usamos configuraciones variables para identificar los errores en la carga
    if ($_ENV['APP_ENV'] === 'local' && $_ENV['APP_DEBUG'] === 'true'){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else {
        error_reporting(0);
    }

    #Inicializamos el sistema de autenticación por JWT
    \App\Core\Auth::init();
?>