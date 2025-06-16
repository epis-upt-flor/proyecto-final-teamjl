<?php

    class EmpleadosController
    {
        public function index(): void
        {
            try {
                $resp = apiRequest('admin_dashboard/empleados.php', 'GET');
                if (!is_array($resp) || !isset($resp['data']) || !is_array($resp['data'])) {
                    throw new \RuntimeException('No se recibieron empleados válidos');
                }
                $empleados = $resp['data'];
                $errorEmp  = null;
            } catch (\Exception $e) {
                error_log('Error cargando empleados: ' . $e->getMessage());
                $empleados = [];
                $errorEmp  = htmlspecialchars($e->getMessage());
            }
            view('empleados', compact('empleados', 'errorEmp'));
        }
    }
?>