<?php
    namespace App\Services;

    use App\Repositories\IncidenciaRepository;

    class IncidenciaService
    {
        public static function obtenerTodas(): array
        {
            return IncidenciaRepository::obtenerTodas();
        }

        public static function asignarEmpleado(int $incidenciaId, int $empleadoId): bool
        {
            return IncidenciaRepository::asignarEmpleado($incidenciaId, $empleadoId);
        }
        

        public static function obtenerPorEmpleado(int $empleadoId): array
        {
            return IncidenciaRepository::obtenerPorEmpleado($empleadoId);
        }

        public static function actualizarEstado(int $incidenciaId, int $estadoId): bool
        {
            return IncidenciaRepository::actualizarEstado($incidenciaId, $estadoId);
        }
    }
?>