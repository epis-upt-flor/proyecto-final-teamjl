<?php

    class DashboardController
    {
        public function index(): void
        {
            try {
                $result = apiRequest('admin_dashboard/resumen_incidencias.php', 'GET');
                if (!is_array($result) || !isset($result['data']) || !is_array($result['data'])) {
                    throw new \RuntimeException('Formato de datos inesperado');
                }
            } catch (\Exception $e) {
                view('error', ['message' => htmlspecialchars($e->getMessage())]);
                return;
            }

            $d = $result['data'];
            view('dashboard', [
                'pendientes'    => (int)($d['Pendiente']     ?? 0),
                'en_desarrollo' => (int)($d['En Desarrollo'] ?? 0),
                'terminadas'    => (int)($d['Terminado']     ?? 0),
            ]);
        }
    }

?>