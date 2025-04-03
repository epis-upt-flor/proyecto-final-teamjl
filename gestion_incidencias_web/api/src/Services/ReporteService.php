<?php
namespace App\Services;

use App\Repositories\ReporteRepository;

class ReporteService
{
    public static function obtenerResumen(): array
    {
        return [
            'por_estado' => ReporteRepository::contarPorEstado(),
            'por_tipo' => ReporteRepository::contarPorTipo()
        ];
    }
}
