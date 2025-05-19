<?php

namespace App\Controllers;

use App\Services\EmpleadoService;
use App\Core\Response;

class EmpleadoController
{
    public static function registrar(array $data): void
    {
        try {
            $nombre = trim($data['nombre'] ?? '');
            $apellido = trim($data['apellido'] ?? '');
            $dni = trim($data['dni'] ?? '');
            $email = trim($data['email'] ?? '');
            $password = trim($data['password'] ?? '');

            if (empty($nombre) || empty($apellido) || empty($dni) || empty($email) || empty($password)) {
                \App\Core\Response::error("Todos los campos son obligatorios", 422);
            }

            $pdo = \App\Core\Database::getInstance();

            $stmt = $pdo->prepare("SELECT id FROM empleado WHERE dni = :dni OR email = :email");
            $stmt->execute(['dni' => $dni, 'email' => $email]);
            if ($stmt->fetch()) {
                \App\Core\Response::error("Ya existe un empleado con ese correo o DNI", 409);
            }

            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $insert = $pdo->prepare("
                    INSERT INTO empleado (nombre, apellido, dni, email, password)
                    VALUES (:nombre, :apellido, :dni, :email, :password)
                ");
            $insert->execute([
                'nombre' => $nombre,
                'apellido' => $apellido,
                'dni' => $dni,
                'email' => $email,
                'password' => $hashed
            ]);

            \App\Core\Response::success([], "Empleado registrado correctamente");
        } catch (\Exception $e) {
            \App\Core\Response::error("Error al registrar: " . $e->getMessage(), 500);
        }
    }

    public static function login(array $data): void
    {
        try {
            $email = trim($data['email'] ?? '');
            $password = trim($data['password'] ?? '');

            if (empty($email) || empty($password)) {
                \App\Core\Response::error("Correo y contraseña obligatorios", 422);
            }

            $pdo = \App\Core\Database::getInstance();
            $stmt = $pdo->prepare("SELECT id, nombre, apellido, email, password FROM empleado WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $empleado = $stmt->fetch();

            if (!$empleado || !password_verify($password, $empleado['password'])) {
                \App\Core\Response::error("Credenciales inválidas", 401);
            }

            $token = \App\Core\Auth::generarToken([
                'id' => $empleado['id'],
                'nombre' => $empleado['nombre'],
                'apellido' => $empleado['apellido'],
                'email' => $empleado['email']
            ]);

            \App\Core\Response::success([
                'empleado' => [
                    'id' => $empleado['id'],
                    'nombre' => $empleado['nombre'],
                    'apellido' => $empleado['apellido'],
                    'email' => $empleado['email']
                ],
                'token' => $token
            ], "Login exitoso");
        } catch (\Exception $e) {
            \App\Core\Response::error("Error al iniciar sesión: " . $e->getMessage(), 500);
        }
    }

    public static function listar(): void
    {
        try {
            $empleados = EmpleadoService::obtenerTodos();
            Response::success($empleados, "Empleados encontrados");
        } catch (\Exception $e) {
            Response::error("Error al obtener empleados: " . $e->getMessage(), 500);
        }
    }
}
