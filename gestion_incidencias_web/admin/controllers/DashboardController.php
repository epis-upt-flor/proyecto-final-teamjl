<?php
    class DashboardController
    {
        public function index()
        {
            try {
                $result = apiRequest('admin_dashboard/resumen_incidencias.php', 'GET');
            } catch (\Exception $e) {
                die("Error cargando dashboard: " . $e->getMessage());
            }

            $data = $result['data'] ?? [];

            view('dashboard', [
                'pendientes'    => $data['Pendiente']     ?? 0,
                'en_desarrollo' => $data['En Desarrollo'] ?? 0,
                'terminadas'    => $data['Terminado']     ?? 0,
            ]);
        }
    }
?>