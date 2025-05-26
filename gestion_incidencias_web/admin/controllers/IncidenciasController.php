<?php
    class IncidenciasController
    {
        public function index()
        {
            try {
                $incResp = apiRequest('admin_dashboard/incidencias.php', 'GET');
                $incidencias = $incResp['data'] ?? [];

                $empResp = apiRequest('admin_dashboard/empleados.php', 'GET');
                $empleados = $empResp['data'] ?? [];

                $prioResp = apiRequest('admin_dashboard/prioridad.php', 'GET');
                $prioridades = $prioResp['data'] ?? [];
            } catch (\Exception $e) {
                error_log("Error cargando Incidencias: " . $e->getMessage());
                $incidencias  = [];
                $empleados    = [];
                $prioridades  = [];
                $errorInc     = $e->getMessage();
            }

            view('incidencias', [
                'incidencias' => $incidencias,
                'empleados'   => $empleados,
                'prioridades' => $prioridades,
                'errorInc'    => $errorInc ?? null,
            ]);
        }
    }
?>