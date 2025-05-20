<?php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
                || $_SERVER['SERVER_PORT'] == 443)
                ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];

    $docRoot    = realpath($_SERVER['DOCUMENT_ROOT']);
    $currentDir = realpath(__DIR__);
    $adminUrl   = str_replace(
        '\\',
        '/',
        substr($currentDir, strlen($docRoot))
    );

    define('BASE_URL', $protocol . $host . $adminUrl . '/index.php?path=');

    define('ADMIN_BASE', $protocol . $host . $adminUrl . '/');

    $projectUrl = dirname($adminUrl);
    define('API_BASE', $protocol . $host . $projectUrl . '/api/public/');
?>