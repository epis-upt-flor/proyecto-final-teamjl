<?php

class IncidenciasController
{
    public function index()
    {
        $incJson  = json_decode(@file_get_contents(API_BASE . 'admin_dashboard/incidencias.php'), true);

        $empJson  = json_decode(@file_get_contents(API_BASE . 'admin_dashboard/empleados.php'), true);

        $prioJson = json_decode(@file_get_contents(API_BASE . 'admin_dashboard/prioridad.php'), true);

        view('incidencias', [
            'incidencias' => $incJson['data']      ?? [],
            'empleados'   => $empJson['data']      ?? [],
            'prioridades' => $prioJson['data']     ?? [],
        ]);
    }

}
