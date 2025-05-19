<?php

class IncidenciasController
{
    public function index()
    {
        $urlInc = API_BASE . 'admin_dashboard/incidencias.php';
        $incResp = @file_get_contents($urlInc);
        $incJson = json_decode($incResp, true);

        if (empty($incJson['success'])) {
            error_log("Error cargando incidencias: " . ($incJson['message'] ?? 'JSON inválido'));
            $incidencias = [];
            $errorInc = $incJson['message'] ?? 'No se pudieron cargar las incidencias.';
        } else {
            $incidencias = $incJson['data'];
            $errorInc = null;
        }

        $urlEmp = API_BASE . 'admin_dashboard/empleados.php';
        $empResp = @file_get_contents($urlEmp);
        $empJson = json_decode($empResp, true);

        if (empty($empJson['success'])) {
            error_log("Error cargando empleados: " . ($empJson['message'] ?? 'JSON inválido'));
            $empleados = [];
            $errorEmp = $empJson['message'] ?? 'No se pudieron cargar los empleados.';
        } else {
            $empleados = $empJson['data'];
            $errorEmp = null;
        }

        view('incidencias', compact('incidencias', 'empleados', 'errorInc', 'errorEmp'));
    }
}
