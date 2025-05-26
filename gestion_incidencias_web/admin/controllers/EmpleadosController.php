<?php

    class EmpleadosController
    {
        public function index()
        {
            try {
                // Llamada al API inyectando el Bearer token desde tu helper
                $resp = apiRequest('admin_dashboard/empleados.php', 'GET');
                $empleados = $resp['data'] ?? [];
                $errorEmp = null;
            } catch (\Exception $e) {
                // Si hay error (401/403/etc.) lo capturamos
                error_log("Error cargando empleados: " . $e->getMessage());
                $empleados = [];
                $errorEmp = $e->getMessage();
            }

            // Renderiza la vista pasándole los empleados y el posible error
            view('empleados', compact('empleados', 'errorEmp'));
        }
    }

?>