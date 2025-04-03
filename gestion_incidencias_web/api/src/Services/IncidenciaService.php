<?php
namespace App\Services;

use App\Repositories\IncidenciaRepository;

class IncidenciaService
{
    public static function obtenerTodas(): array
    {
        return IncidenciaRepository::obtenerTodas();
    }
}
