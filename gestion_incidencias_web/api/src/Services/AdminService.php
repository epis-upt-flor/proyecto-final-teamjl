<?php
    namespace App\Services;

    use App\Repositories\AdminRepository;
    use App\Core\Auth;

    class AdminService
    {
        public static function login(string $email, string $password): ?array
        {
            $admin = AdminRepository::obtenerPorEmail($email);

            if (!$admin || !password_verify($password, $admin['password'])) {
                return null;
            }

            $token = Auth::generarToken([
                'admin_id' => $admin['id'],
                'nombre' => $admin['nombre'],
                'email' => $admin['email']
            ]);

            return [
                'id' => $admin['id'],
                'nombre' => $admin['nombre'],
                'email' => $admin['email'],
                'token' => $token
            ];
        }

        public static function registrar(array $data): bool
        {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            return AdminRepository::registrar($data);
        }
    }
?>