<?php
require_once("../../inc/db.php");
require_once("fpdf/fpdf.php");

$inicio = $_GET['inicio'] ?? date('Y-m-01');
$fin = $_GET['fin'] ?? date('Y-m-d');

$reporte = $pdo->prepare("
    SELECT i.id, ti.nombre AS tipo, ei.nombre AS estado, i.fecha_reporte
    FROM incidencia i
    JOIN tipo_incidencia ti ON i.tipo_id = ti.id
    JOIN estado_incidencia ei ON i.estado_id = ei.id
    WHERE i.fecha_reporte BETWEEN :inicio AND :fin
    ORDER BY i.fecha_reporte DESC
");
$reporte->execute(['inicio' => $inicio, 'fin' => $fin]);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Reporte General de Incidencias', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Desde: $inicio   Hasta: $fin", 0, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 10, 'ID', 1);
$pdf->Cell(60, 10, 'Tipo', 1);
$pdf->Cell(40, 10, 'Estado', 1);
$pdf->Cell(60, 10, 'Fecha', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
foreach ($reporte as $row) {
    $pdf->Cell(20, 10, $row['id'], 1);
    $pdf->Cell(60, 10, $row['tipo'], 1);
    $pdf->Cell(40, 10, $row['estado'], 1);
    $pdf->Cell(60, 10, $row['fecha_reporte'], 1);
    $pdf->Ln();
}

$pdf->Output();
exit();
