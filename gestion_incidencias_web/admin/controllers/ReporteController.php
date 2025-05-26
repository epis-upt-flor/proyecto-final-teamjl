<?php

    class ReporteController
    {
        public function index()
        {
            $inicio = $_GET['inicio'] ?? date('Y-m-01');
            $fin    = $_GET['fin']    ?? date('Y-m-d');

            try {
                $resp = apiRequest(
                    "admin_dashboard/resumen_estadistico.php?inicio={$inicio}&fin={$fin}",
                    'GET'
                );
                $datos     = $resp['data'] ?? [];
                $por_estado = $datos['por_estado'] ?? [];
                $por_tipo   = $datos['por_tipo']   ?? [];
                $errorReport = null;
            } catch (\Exception $e) {
                error_log("Error cargando reportes: " . $e->getMessage());
                $por_estado   = [];
                $por_tipo     = [];
                $errorReport  = $e->getMessage();
            }

            view('reporte', compact(
                'por_estado', 'por_tipo', 'inicio', 'fin', 'errorReport'
            ));
        }

        public function exportPdf()
        {
            $inicio = urlencode($_GET['inicio'] ?? date('Y-m-01'));
            $fin    = urlencode($_GET['fin']    ?? date('Y-m-d'));

            header(
                'Location: '
                . ADMIN_BASE
                . "reporte/generar_pdf.php?inicio={$inicio}&fin={$fin}"
            );
            exit;
        }

        public function exportExcel()
        {
            $inicio = urlencode($_GET['inicio'] ?? date('Y-m-01'));
            $fin    = urlencode($_GET['fin']    ?? date('Y-m-d'));
            header('Location: ' 
                . API_BASE 
                . "admin_dashboard/reporte_csv.php?inicio={$inicio}&fin={$fin}"
            );
            exit;
        }
    }

?>