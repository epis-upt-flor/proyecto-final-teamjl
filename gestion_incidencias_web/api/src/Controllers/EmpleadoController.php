<?php

namespace App\Controllers;

use App\Core\Database;
use App\Core\Response;
use App\Core\Auth;
use PDOException;

class EmpleadoController
{
    public static function registrar(array $data): void
    {
        if (
            empty($data['dni']) ||
            empty($data['nombre']) ||
            empty($data['apellido']) ||
            empty($data['email']) ||
            empty($data['password'])
        ) {
            Response::error("Todos los campos son obligatorios", 422);
        }

        $dni = trim($data['dni']);
        $nombre = trim($data['nombre']);
        $apellido = trim($data['apellido']);
        $email = trim($data['email']);
        $password = trim($data['password']);

        try {
            $pdo = Database::getInstance();

            $check = $pdo->prepare("SELECT id FROM empleado WHERE email = :email OR dni = :dni");
            $check->execute(['email' => $email, 'dni' => $dni]);

            if ($check->fetch()) {
                Response::error("El correo o DNI ya está registrado", 409);
            }

            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $insert = $pdo->prepare("
                INSERT INTO empleado (dni, nombre, apellido, email, password)
                VALUES (:dni, :nombre, :apellido, :email, :password)
            ");
            $insert->execute([
                'dni' => $dni,
                'nombre' => $nombre,
                'apellido' => $apellido,
                'email' => $email,
                'password' => $hashed
            ]);

            Response::success([], "Empleado registrado correctamente");
        } catch (PDOException $e) {
            Response::error("Error en el registro: " . $e->getMessage(), 500);
        }
    }

    public static function login(array $data): void
    {
        if (empty($data['email']) || empty($data['password'])) {
            Response::error("Correo y contraseña son obligatorios", 422);
        }

        $email = trim($data['email']);
        $password = trim($data['password']);

        try {
            $pdo = Database::getInstance();

            $stmt = $pdo->prepare("SELECT * FROM empleado WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $empleado = $stmt->fetch();

            if (!$empleado || !password_verify($password, $empleado['password'])) {
                Response::error("Credenciales inválidas", 401);
            }

            $token = Auth::generarToken([
                'empleado_id' => $empleado['id'],
                'nombre' => $empleado['nombre']
            ]);

            Response::success([
                'token' => $token,
                'empleado_id' => $empleado['id'],
                'nombre' => $empleado['nombre']
            ], "Inicio de sesión exitoso");
        } catch (PDOException $e) {
            Response::error("Error interno: " . $e->getMessage(), 500);
        }
    }
}
