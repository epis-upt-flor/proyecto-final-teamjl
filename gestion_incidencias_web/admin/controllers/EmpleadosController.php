<?php
    class EmpleadosController
    {
        public function index()
        {
            try {
                $resp = apiRequest('admin_dashboard/empleados.php', 'GET');
                $empleados = $resp['data'] ?? [];
                $errorEmp = null;
            } catch (\Exception $e) {
                error_log("Error cargando empleados: " . $e->getMessage());
                $empleados = [];
                $errorEmp = $e->getMessage();
            }

            view('empleados', compact('empleados', 'errorEmp'));
        }
    }
?>