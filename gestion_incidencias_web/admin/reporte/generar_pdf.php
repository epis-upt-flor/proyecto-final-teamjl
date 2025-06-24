<?php
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/fpdf/fpdf.php';

    $inicio = filter_input(INPUT_GET, 'inicio', FILTER_SANITIZE_STRING) ?: date('Y-m-01');
    $fin    = filter_input(INPUT_GET, 'fin', FILTER_SANITIZE_STRING) ?: date('Y-m-d');

    $token = $_SESSION['token'] ?? '';

    function fetchApiData($url, $token)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $token"
            ]
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true)['data'] ?? [];
    }

    $urlGrp = API_BASE . "admin_dashboard/incidencias_por_empleado.php?inicio={$inicio}&fin={$fin}";
    $dataGrp = fetchApiData($urlGrp, $token);

    $urlEst = API_BASE . "admin_dashboard/resumen_estadistico.php?inicio={$inicio}&fin={$fin}";
    $dataEst = fetchApiData($urlEst, $token);
    $porEstado = $dataEst['por_estado'] ?? [];
    $porTipo   = $dataEst['por_tipo'] ?? [];

    function fetchChartImage(string $config, string $out)
    {
        $url = 'https://quickchart.io/chart?c=' . rawurlencode($config)
            . '&width=600&height=300&format=png';
        if ($img = @file_get_contents($url)) {
            file_put_contents($out, $img);
        }
    }

    $configEstado = json_encode([
        'type' => 'doughnut',
        'data' => [
            'labels' => array_map(fn($e) => $e['estado'], $porEstado),
            'datasets' => [[
                'data' => array_map(fn($e) => $e['total'], $porEstado),
                'backgroundColor' => ['#dc3545', '#ffc107', '#28a745', '#0dcaf0']
            ]]
        ],
        'options' => ['plugins' => ['legend' => ['position' => 'bottom']]]
    ]);

    $configTipo = json_encode([
        'type' => 'bar',
        'data' => [
            'labels' => array_map(fn($t) => $t['tipo'], $porTipo),
            'datasets' => [[
                'label' => 'Cantidad',
                'data' => array_map(fn($t) => $t['total'], $porTipo),
                'backgroundColor' => '#0d6efd'
            ]]
        ],
        'options' => [
            'scales' => ['y' => ['beginAtZero' => true]],
            'plugins' => ['legend' => ['display' => false]]
        ]
    ]);

    $temp1 = __DIR__ . '/chart_estado.png';
    $temp2 = __DIR__ . '/chart_tipo.png';
    fetchChartImage($configEstado, $temp1);
    fetchChartImage($configTipo, $temp2);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Reporte de Incidencias por Empleado', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "Desde: $inicio   Hasta: $fin", 0, 1);
    $pdf->Ln(4);

    if (!empty($dataGrp)) {
        foreach ($dataGrp as $emp) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 8, utf8_decode($emp['empleado']), 0, 1);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(20, 8, 'ID', 1);
            $pdf->Cell(50, 8, 'Tipo', 1);
            $pdf->Cell(40, 8, 'Estado', 1);
            $pdf->Cell(40, 8, 'Fecha', 1);
            $pdf->Ln();

            $pdf->SetFont('Arial', '', 10);
            foreach ($emp['incidencias'] as $inc) {
                $pdf->Cell(20, 8, $inc['id'], 1);
                $pdf->Cell(50, 8, utf8_decode($inc['tipo']), 1);
                $pdf->Cell(40, 8, utf8_decode($inc['estado']), 1);
                $pdf->Cell(40, 8, $inc['fecha_reporte'], 1);
                $pdf->Ln();
            }
            $pdf->Ln(4);
        }
    } else {
        $pdf->SetFont('Arial', 'I', 11);
        $pdf->Cell(0, 10, 'No hay incidencias registradas en este rango.', 0, 1);
    }

    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Resumen Gráfico', 0, 1, 'C');
    $pdf->Image($temp1, 15, 30, 180);
    $pdf->Ln(95);
    $pdf->Image($temp2, 15, null, 180);

    @unlink($temp1);
    @unlink($temp2);
    $pdf->Output('I', "incidencias_por_empleado_{$inicio}_a_{$fin}.pdf");
    exit;
?>