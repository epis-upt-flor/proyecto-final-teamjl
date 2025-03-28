<?php
    $host = "localhost";
    $port = "5432";
    $dbname = "dbGestionJL";
    $user = "postgres";
    $password = "upt2025";

    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
?>