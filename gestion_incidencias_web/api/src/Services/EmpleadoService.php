<?php
    namespace App\Services;

    use App\Repositories\EmpleadoRepository;

    class EmpleadoService
    {
        public static function obtenerTodos(): array
        {
            return EmpleadoRepository::obtenerTodos();
        }
    }
?>