<?php

class ReporteController
{
    public function index()
    {
        $inicio = $_GET['inicio'] ?? date('Y-m-01');
        $fin    = $_GET['fin']    ?? date('Y-m-d');

        $urlEst = API_BASE . 'admin_dashboard/resumen_estadistico.php'
                  . "?inicio={$inicio}&fin={$fin}";
        $resEst = @file_get_contents($urlEst);
        $jsonEst = json_decode($resEst, true);

        if (!empty($jsonEst['success'])) {
            $por_estado = $jsonEst['data']['por_estado'] ?? [];
        } else {
            error_log("Error resumen_estadistico: " . ($jsonEst['message'] ?? 'JSON inválido'));
            $por_estado = [];
        }

        $por_tipo = $jsonEst['data']['por_tipo'] ?? [];

        view('reporte', compact('por_estado', 'por_tipo', 'inicio', 'fin'));
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

        header(
            'Location: '
            . ADMIN_BASE
            . "reporte/generar_excel.php?inicio={$inicio}&fin={$fin}"
        );
        exit;
    }
}
