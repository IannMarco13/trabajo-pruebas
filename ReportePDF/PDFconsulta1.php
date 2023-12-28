<?php
require('fpdf.php');
require_once ('../conexion.php');
//ob_end_clean();
use Carbon\Carbon;
require __DIR__ . '/../vendor/autoload.php';


class PDF extends FPDF
{
   // Cabecera de página
   function Header()
   {
      //include '../../recursos/Recurso_conexion_bd.php';//llamamos a la conexion BD
      //$consulta_info = $conexion->query(" select *from hotel ");//traemos datos de la empresa desde BD
      //$dato_info = $consulta_info->fetch_object();
      $this->Image('img/logo.png', 270, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(95); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(110, 15, utf8_decode('GAMBARTE'), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(1); // Salto de línea
       //color

      /* letras pequenas */ 
      $this->SetTextColor(103); //PARA PODER CAMBIAR EL COLOR DE LA LETRA TIENE QUE ESTAR ENSIMA DE TODO
      $this->Cell(100); // mover a la derecha
      $this->SetFont('Arial', 'I', 8);
      $this->Cell(100,-9, utf8_decode('Giros-Remesas de Dienro'),0,0,'C',0);
      $this->Ln(5);
      
      /* TITULO DE LA TABLA */
      
      $this->SetTextColor(228, 100, 0);//color
      $this->Cell(100); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("REPORTE DE REMESAS PAGADAS"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(228, 100, 0); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(10, 10, utf8_decode('N°'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('CODIGO'), 1, 0, 'C', 1);
      $this->Cell(75, 10, utf8_decode('REMITENTE'), 1, 0, 'C', 1);
      $this->Cell(40, 10, utf8_decode('FECHA ENVIO'), 1, 0, 'C', 1);
      $this->Cell(40, 10, utf8_decode('FECHA PAGO'), 1, 0, 'C', 1);
      $this->Cell(40, 10, utf8_decode('ESTADO F ENVIO'), 1, 0, 'C', 1);
      $this->Cell(40, 10, utf8_decode('ESTADO F PAGO'), 1, 1, 'C', 1);

   }
   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(540, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

$pdf = new PDF();
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

//validar aca si no son = votar a usandon redirec
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

$fechaInicio = Carbon::createFromFormat('Y-m-d', $from_date);
$fechaFin = Carbon::createFromFormat('Y-m-d', $to_date);

// Crear una instancia de Carbon con la fecha y hora actual
$fechaActual = Carbon::now();

if ($fechaInicio->isFuture() || $fechaFin->isFuture()) {
    // Si alguna de las fechas está en el futuro
    echo '<script>alert("No puedes ingresar fechas futuras a'.$fechaActual.'"); window.location.href = "../RepComEStado.php";</script>';
}

if ($fechaInicio <= $fechaFin ){


$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

$query = ("SELECT remesas_env_chile_bolivia.CODIGO,remesas_env_chile_bolivia.REMITENTE, remesas_env_chile_bolivia.FECHA, report_chile_bolivia.FECHA_PAG,remesas_env_chile_bolivia.ESTADO, report_chile_bolivia.ESTADO_R FROM remesas_env_chile_bolivia INNER JOIN report_chile_bolivia ON remesas_env_chile_bolivia.AIR = report_chile_bolivia.AIR_R WHERE remesas_env_chile_bolivia.ESTADO != report_chile_bolivia.ESTADO_R AND DATE(FECHA) BETWEEN '$from_date' AND '$to_date'");

$query_run = mysqli_query($conexion, $query);
if(mysqli_num_rows($query_run) > 0){
   foreach($query_run as $fila){     
    $i = $i + 1;
    /* TABLA */
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 10, utf8_decode($i), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode($fila['CODIGO']), 1, 0, 'C', 0);
    $pdf->Cell(75, 10, utf8_decode($fila['REMITENTE']), 1, 0, 'C', 0);
    $pdf->Cell(40, 10, utf8_decode(date('d-m-Y h:i', strtotime($fila['FECHA']))), 1, 0, 'C', 0);
    $pdf->Cell(40, 10, utf8_decode(date('d-m-Y h:i', strtotime($fila['FECHA_PAG']))), 1, 0, 'C', 0);
    $pdf->Cell(40, 10, utf8_decode($fila['ESTADO']), 1, 0, 'C', 0);
    $pdf->Cell(40, 10, utf8_decode($fila['ESTADO_R']), 1, 1, 'C', 0);
    }
} 

// Consulta SQL para la segunda tabla
// Agrega una página en orientación horizontal al PDF

$query_cont = "SELECT COUNT(MONEDA) AS cant_bob FROM remesas_env_chile_bolivia INNER JOIN report_chile_bolivia ON remesas_env_chile_bolivia.AIR = report_chile_bolivia.AIR_R WHERE remesas_env_chile_bolivia.ESTADO != report_chile_bolivia.ESTADO_R AND DATE(FECHA) BETWEEN '$from_date' AND '$to_date' AND remesas_env_chile_bolivia.MONEDA = 'BOB'";

$query_run_cont = mysqli_query($conexion, $query_cont);

if ($query_run_cont) {
    $result = mysqli_fetch_assoc($query_run_cont);
    $cant_bob = $result['cant_bob'];        

    // Encabezado de la tabla
    $pdf->Ln(); // Salto de línea antes de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10,utf8_decode('Cantidad Envios[BOB]'), 1, 0, 'C', 0);// ver borde,salto de linea, posision del conetenido , nose    Salto de línea después de la fila
    // Contenido de la tabla
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20, 10, $cant_bob, 1, 0, 'C',0);
       // Salto de línea después de la fila

} else {
    // Manejar el error si la consulta falla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Error en la consulta de conteo:', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, mysqli_error($conexion), 0, 1);
}
$query_cont_usd = "SELECT COUNT(MONEDA) AS cant_usd FROM remesas_env_chile_bolivia INNER JOIN report_chile_bolivia ON remesas_env_chile_bolivia.AIR = report_chile_bolivia.AIR_R WHERE remesas_env_chile_bolivia.ESTADO != report_chile_bolivia.ESTADO_R AND DATE(FECHA) BETWEEN '$from_date' AND '$to_date' AND remesas_env_chile_bolivia.MONEDA = 'USD'";

$query_run_cont_usd = mysqli_query($conexion, $query_cont_usd);

if ($query_run_cont) {
    $result = mysqli_fetch_assoc($query_run_cont_usd);
    $cant_usd = $result['cant_usd'];

    // Encabezado de la tabla
    $pdf->Ln(); // Salto de línea antes de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10,utf8_decode('Cantidad Envios[USD]'), 1, 0, 'C', 0);// ver borde,salto de linea, posision del conetenido , nose    Salto de línea después de la fila
    // Contenido de la tabla
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(20, 10, $cant_usd, 1, 0, 'C',0);
       // Salto de línea después de la fila

} else {
    // Manejar el error si la consulta falla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Error en la consulta de conteo:', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, mysqli_error($conexion), 0, 1);
}

$query_T = "SELECT SUM(report_chile_bolivia.MONTO_BOB) AS sum_bob, SUM(report_chile_bolivia.MONTO_USD) AS sum_usd FROM remesas_env_chile_bolivia INNER JOIN report_chile_bolivia ON remesas_env_chile_bolivia.AIR = report_chile_bolivia.AIR_R WHERE remesas_env_chile_bolivia.ESTADO != report_chile_bolivia.ESTADO_R AND DATE(FECHA) BETWEEN '$from_date' AND '$to_date'";

$query_run_T = mysqli_query($conexion, $query_T);

if ($query_run_T) {
    $result = mysqli_fetch_assoc($query_run_T);
    $sum_bob = $result['sum_bob'];
    $sum_usd = $result['sum_usd'];

    // Encabezado de la tabla
    $pdf->Ln(); // Salto de línea antes de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10,utf8_decode('N° TOTAL'), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode('Total BOB'), 1,0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode('Total USD'), 1, 1,'C', 0); // ver borde,salto de linea, posision del conetenido , nose    Salto de línea después de la fila

    // Contenido de la tabla
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(30,10, $i, 1,0, 'C',);
    $pdf->Cell(30, 10, $sum_bob, 1, 0, 'C');
    $pdf->Cell(30, 10, $sum_usd, 1, 1, 'C'); // Salto de línea después de la fila

} else {
    // Manejar el error si la consulta falla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Error en la consulta de conteo:', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, mysqli_error($conexion), 0, 1);
}
}
else {
    echo '<script>alert("Fecha incorrecta"); window.location.href = "../RepComEStado.php";</script>';

}
$pdf->Output('Consulta1.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
?>
