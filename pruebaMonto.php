<?php
require('ReportePDF/fpdf.php');
// Obtener las fechas
$from_date = $_GET['from_date'] ?? null;
//var_dump($from_date);
$to_date = $_GET['to_date'] ?? null;
//var_dump($to_date);
require_once 'conexion.php';
$queryBob = "SELECT SUM(MONTO_BOB) AS total_monto_bob FROM report_chile_bolivia WHERE DATE(FECHA_ORI) BETWEEN '$from_date' AND '$to_date'";

$resultBob = $conexion->query($queryBob);
$rowBob = $resultBob->fetch_assoc();
$totalMontoBob = $rowBob['total_monto_bob'];

// Consulta para obtener el total de MONTO_USD
$queryUsd = "SELECT SUM(MONTO_USD) AS total_monto_usd FROM report_chile_bolivia WHERE DATE(FECHA_ORI) BETWEEN '$from_date' AND '$to_date'";

$resultUsd = $conexion->query($queryUsd);
$rowUsd = $resultUsd->fetch_assoc();
$totalMontoUsd = $rowUsd['total_monto_usd'];

// Consulta para obtener el total de MONTO_ENV entre las fechas
$queryMontoEnviado = "SELECT SUM(MONTO_ENV) AS total_monto_enviado FROM remesas_bolivia_chile WHERE DATE(FECHA_B) BETWEEN '$from_date' AND CURDATE()";

$resultMontoEnviado = $conexion->query($queryMontoEnviado);
$rowMontoEnviado = $resultMontoEnviado->fetch_assoc();
$totalMontoEnviado = $rowMontoEnviado['total_monto_enviado'];

// Realizar cálculos

$totalMontoFinal = round($totalMontoBob / 6.86,2) + $totalMontoUsd ;

$diferencia = abs($totalMontoFinal -$totalMontoEnviado);
// Mostrar resultados
//echo "<br>Total Monto BOB enviado por Chile: " . $totalMontoBob . "<br>";
//echo "Total Monto USD enviado por Chile: " . $totalMontoUsd . "<br>";
//echo "Total Final Enviado por Chile " . $totalMontoFinal . "<br><br>";

//echo "Total Monto Enviado por Bolivia: " . $totalMontoEnviado . "<br>";

if ($totalMontoFinal > $totalMontoEnviado){

    $diferencia = abs($totalMontoFinal -$totalMontoEnviado);
  //  echo "La diferencia de envio entre Chile - Bolivia es: ".$diferencia."<br>";
}else {
    $diferencia = abs($totalMontoFinal - $totalMontoEnviado);
    //echo "La diferencia de envio entre Bolivia - Chile es de: ".$diferencia."<br>";
}

// Crear un nuevo objeto FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Establecer la fuente y el tamaño del texto
$pdf->SetFont('Arial', '', 12);

// Contenido del PDF
$pdf->Cell(0, 10, utf8_decode('Reporte de Envíos'), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Total Monto BOB enviado por Chile: ') . $totalMontoBob, 0, 1);
$pdf->Cell(0, 10, utf8_decode('Total Monto USD enviado por Chile: ') . $totalMontoUsd, 0, 1);
$pdf->Cell(0, 10, utf8_decode('Total Final Enviado por Chile: '). $totalMontoFinal, 0, 1);
$pdf->Cell(0, 10, utf8_decode('Total Monto Enviado por Bolivia: ') . $totalMontoEnviado, 0, 1);

$pdf->Cell(0, 10, utf8_decode('Total Monto Enviado por Bolivia: ') . $diferencia, 0, 1);

// Nombre del archivo PDF
$fileName = 'reporte_envios.pdf';

// Salida del PDF para mostrar en una ventana nueva
$pdf->Output($fileName, 'I');
?>

