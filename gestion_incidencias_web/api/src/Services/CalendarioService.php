<?php
    namespace App\Services;

    use App\Repositories\CalendarioRepository;

    class CalendarioService
    {
        public static function programar(int $incidenciaId, string $fecha): bool
        {
            $fechaActual = date('Y-m-d');
            if ($fecha < $fechaActual) {
                return false;
            }
            return CalendarioRepository::guardarFecha($incidenciaId, $fecha);
        }

        // NUEVO MÉTODO para usar al asignar empleado + prioridad + fecha
        public static function programarAlAsignar(int $incidenciaId, string $fecha): bool
        {
            $fechaActual = date('Y-m-d');
            if ($fecha < $fechaActual) {
                return false;
            }
            return CalendarioRepository::guardarFecha($incidenciaId, $fecha);
        }
    }
?>