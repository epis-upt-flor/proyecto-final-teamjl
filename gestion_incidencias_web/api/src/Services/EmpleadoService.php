<?php

    namespace App\Services;

    use App\Repositories\EmpleadoRepository;
    use App\Core\Auth;

    class EmpleadoService
    {
        public static function obtenerTodos(): array
        {
            return EmpleadoRepository::obtenerTodos();
        }

        public static function registerRaw(
            string $nombre,
            string $apellido,
            string $dni,
            string $email,
            string $password
        ): int {
            session_start();
            $creadoPor = $_SESSION['usuario_id'] ?? null;

            return EmpleadoRepository::create([
                'nombre'     => $nombre,
                'apellido'   => $apellido,
                'dni'        => $dni,
                'email'      => $email,
                'password'   => password_hash($password, PASSWORD_DEFAULT),
                'creado_por' => $creadoPor
            ]);
        }

        public static function loginRaw(string $email, string $password): ?array
        {
            $emp = EmpleadoRepository::obtenerPorEmail($email);
            if (!$emp || !password_verify($password, $emp['password'])) {
                return null;
            }
            $token = Auth::generarToken([
                'id'       => $emp['id'],
                'nombre'   => $emp['nombre'],
                'apellido' => $emp['apellido'],
                'email'    => $emp['email'],
                'role'     => 'empleado'
            ]);
            return [
                'id'       => $emp['id'],
                'nombre'   => $emp['nombre'],
                'apellido' => $emp['apellido'],
                'email'    => $emp['email'],
                'role'     => 'empleado',
                'token'    => $token
            ];
        }
    }
?>