<?php
// admin/controllers/ReporteController.php

class ReporteController
{
    /**
     * Muestra el formulario de rango + los gráficos
     * URL: /admin/index.php?path=reporte&inicio=YYYY-MM-DD&fin=YYYY-MM-DD
     */
    public function index()
    {
        // Rango de fechas por GET o valores por defecto
        $inicio = $_GET['inicio'] ?? date('Y-m-01');
        $fin    = $_GET['fin']    ?? date('Y-m-d');

        // 1) Estadísticas por estado
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

        // 2) Estadísticas por tipo
        // El mismo endpoint devuelve por_tipo
        $por_tipo = $jsonEst['data']['por_tipo'] ?? [];

        // Renderiza la vista con datos y rango
        view('reporte', compact('por_estado', 'por_tipo', 'inicio', 'fin'));
    }

    /**
     * Redirige al endpoint de PDF con los mismos parámetros
     */
    public function exportPdf()
    {
        $inicio = urlencode($_GET['inicio'] ?? date('Y-m-01'));
        $fin    = urlencode($_GET['fin']    ?? date('Y-m-d'));

        // Redirige al script front-end que genera el PDF:
        header('Location: ' 
            . ADMIN_BASE 
            . "reporte/generar_pdf.php?inicio={$inicio}&fin={$fin}"
        );
        exit;
    }

    /**
     * Redirige al endpoint de CSV/Excel con los mismos parámetros
     */
    public function exportExcel()
    {
        $inicio = urlencode($_GET['inicio'] ?? date('Y-m-01'));
        $fin    = urlencode($_GET['fin']    ?? date('Y-m-d'));

        // Redirige al script front-end que genera el CSV:
        header('Location: ' 
            . ADMIN_BASE 
            . "reporte/generar_excel.php?inicio={$inicio}&fin={$fin}"
        );
        exit;
    }
}
