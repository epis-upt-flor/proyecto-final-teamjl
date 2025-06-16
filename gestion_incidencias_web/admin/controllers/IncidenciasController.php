<?php

    class IncidenciasController
    {
        public function index(): void
        {
            $errorInc = null;
            try {
                $incResp = apiRequest('admin_dashboard/incidencias.php', 'GET');
                if (!is_array($incResp) || !isset($incResp['data']) || !is_array($incResp['data'])) {
                    throw new \RuntimeException('Incidencias inválidas');
                }
                $incidencias = $incResp['data'];

                $empResp = apiRequest('admin_dashboard/empleados.php', 'GET');
                if (!is_array($empResp) || !isset($empResp['data']) || !is_array($empResp['data'])) {
                    throw new \RuntimeException('Empleados inválidos');
                }
                $empleados = $empResp['data'];

                $prioResp = apiRequest('admin_dashboard/prioridad.php', 'GET');
                if (!is_array($prioResp) || !isset($prioResp['data']) || !is_array($prioResp['data'])) {
                    throw new \RuntimeException('Prioridades inválidas');
                }
                $prioridades = $prioResp['data'];
            } catch (\Exception $e) {
                error_log('Error cargando Incidencias: ' . $e->getMessage());
                $incidencias = [];
                $empleados   = [];
                $prioridades = [];
                $errorInc    = htmlspecialchars($e->getMessage());
            }

            view('incidencias', [
                'incidencias' => $incidencias,
                'empleados'   => $empleados,
                'prioridades' => $prioridades,
                'errorInc'    => $errorInc,
            ]);
        }
    }
?>