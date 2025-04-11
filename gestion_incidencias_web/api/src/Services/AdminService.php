<?php
namespace App\Services;

use App\Repositories\AdminRepository;

class AdminService
{
    public static function login(string $email, string $password): ?array
    {
        $admin = AdminRepository::obtenerPorEmail($email);

        if (!$admin || !password_verify($password, $admin['password'])) {
            return null;
        }

        return $admin;
    }

    public static function registrar(array $data): bool
    {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return AdminRepository::registrar($data);
    }
}
