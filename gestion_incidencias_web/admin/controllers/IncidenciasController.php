<?php

    class IncidenciasController
    {
        public function index()
        {
            // 1) Si no hay token, tu middleware ya te redirige al login

            try {
                // 2) Petición a incidencias
                $incResp = apiRequest('admin_dashboard/incidencias.php', 'GET');
                $incidencias = $incResp['data'] ?? [];

                // 3) Petición a empleados (para el dropdown de asignación)
                $empResp = apiRequest('admin_dashboard/empleados.php', 'GET');
                $empleados = $empResp['data'] ?? [];

                // 4) Petición a prioridades
                $prioResp = apiRequest('admin_dashboard/prioridad.php', 'GET');
                $prioridades = $prioResp['data'] ?? [];
            } catch (\Exception $e) {
                // Si falla alguna llamada, logueas y pasas arrays vacíos
                error_log("Error cargando Incidencias: " . $e->getMessage());
                $incidencias  = [];
                $empleados    = [];
                $prioridades  = [];
                $errorInc     = $e->getMessage();
            }

            // 5) Renderizas la vista con todos los datos
            view('incidencias', [
                'incidencias' => $incidencias,
                'empleados'   => $empleados,
                'prioridades' => $prioridades,
                'errorInc'    => $errorInc ?? null,
            ]);
        }

    }

?>