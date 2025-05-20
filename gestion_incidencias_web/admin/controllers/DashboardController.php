<?php

    class DashboardController
    {
        public function index()
        {
            $json = file_get_contents(API_BASE . 'admin_dashboard/resumen_incidencias.php');
            $data = json_decode($json, true)['data'] ?? [];

            view('dashboard', [
                'pendientes'    => $data['Pendiente']    ?? 0,
                'en_desarrollo' => $data['En Desarrollo'] ?? 0,
                'terminadas'    => $data['Terminado']    ?? 0,
            ]);
        }
    }

?>