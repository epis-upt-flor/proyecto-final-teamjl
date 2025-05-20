<?php

    class EmpleadosController
    {
        public function index()
        {
            $url = API_BASE . 'admin_dashboard/empleados.php';
            $resp = @file_get_contents($url);
            $json = json_decode($resp, true);

            if (empty($json['success'])) {
                error_log("Error cargando empleados: " . ($json['message'] ?? 'JSON inválido'));
                $empleados = [];
                $errorEmp  = $json['message'] ?? 'No se pudieron cargar los empleados.';
            } else {
                $empleados = $json['data'];
                $errorEmp  = null;
            }

            view('empleados', compact('empleados', 'errorEmp'));
        }
    }

?>