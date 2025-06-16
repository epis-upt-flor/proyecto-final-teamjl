<?php

    class ReporteController
    {
        public function index(): void
        {
            $inicio = (string)($_GET['inicio'] ?? date('Y-m-01'));
            $fin    = (string)($_GET['fin']    ?? date('Y-m-d'));

            try {
                $resp = apiRequest(
                    'admin_dashboard/resumen_estadistico.php'
                    . '?inicio=' . urlencode($inicio)
                    . '&fin='    . urlencode($fin),
                    'GET'
                );
                if (!is_array($resp) || !isset($resp['data']) || !is_array($resp['data'])) {
                    throw new \RuntimeException('Datos de reporte inválidos');
                }
                $datos      = $resp['data'];
                $por_estado = $datos['por_estado'] ?? [];
                $por_tipo   = $datos['por_tipo']   ?? [];
                $errorReport = null;
            } catch (\Exception $e) {
                error_log('Error cargando reportes: ' . $e->getMessage());
                $por_estado  = [];
                $por_tipo    = [];
                $errorReport = htmlspecialchars($e->getMessage());
            }

            view('reporte', compact('por_estado', 'por_tipo', 'inicio', 'fin', 'errorReport'));
        }

        public function exportPdf(): void
        {
            $inicio = urlencode((string)($_GET['inicio'] ?? date('Y-m-01')));
            $fin    = urlencode((string)($_GET['fin']    ?? date('Y-m-d')));
            $url    = ADMIN_BASE . 'reporte/generar_pdf.php'
                    . '?inicio=' . $inicio
                    . '&fin='    . $fin;

            header('Location: ' . $url);
            exit;
        }

        public function exportExcel(): void
        {
            $inicio = urlencode((string)($_GET['inicio'] ?? date('Y-m-01')));
            $fin    = urlencode((string)($_GET['fin']    ?? date('Y-m-d')));
            $url    = API_BASE . 'admin_dashboard/reporte_csv.php'
                    . '?inicio=' . $inicio
                    . '&fin='    . $fin;

            header('Location: ' . $url);
            exit;
        }
    }
?>