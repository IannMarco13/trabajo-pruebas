<?php

require('fpdf\fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      include 'conexion.php';
      //$consulta_info = $conexion->query(" select *from report_chile_bolivia ");//traemos datos de la empresa desde BD
      //$dato_info = $consulta_info->fetch_object();
      //include '../../recursos/Recurso_conexion_bd.php';//llamamos a la conexion BD
      
      //$consulta_info = $conexion->query(" select *from hotel ");//traemos datos de la empresa desde BD
      //$dato_info = $consulta_info->fetch_object();
      $this->Image('logo.png', 185, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(110, 15, utf8_decode('Gambarte'), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color

      /* UBICACION */
      $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(96, 10, utf8_decode("Ubicación : "), 0, 0, '', 0);
      $this->Ln(5);

      /* TELEFONO */
      $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(59, 10, utf8_decode("Teléfono : "), 0, 0, '', 0);
      $this->Ln(5);

      /* COREEO */
      $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 10, utf8_decode("Correo : "), 0, 0, '', 0);
      $this->Ln(5);

      /* TELEFONO */
      $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 10, utf8_decode("Sucursal : "), 0, 0, '', 0);
      $this->Ln(10);

      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(228, 100, 0);
      $this->Cell(50); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("REPORTE DE HABITACIONES "), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(228, 100, 0); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(18, 10, utf8_decode('Codigo'), 1, 0, 'C', 1);
      $this->Cell(20, 10, utf8_decode('Codigo'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('Fecha Envio'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('Fecha Pago'), 1, 0, 'C', 1);
      $this->Cell(70, 10, utf8_decode('Estado'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('ESTADO'), 1, 1, 'C', 1);
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
      $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

//include '../../recursos/Recurso_conexion_bd.php';
//require '../../funciones/CortarCadena.php';
/* CONSULTA INFORMACION DEL HOSPEDAJE */
//$consulta_info = $conexion->query(" select *from hotel ");
//$dato_info = $consulta_info->fetch_object();

$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

/*$consulta_reporte_alquiler = $conexion->query("  ");*/
$consulta_reporte_alquiler = $conexion->query("SELECT remesas_env_chile_bolivia.CODIGO, report_chile_bolivia.CODIGO_R, remesas_env_chile_bolivia.FECHA, report_chile_bolivia.FECHA_ORI,report_chile_bolivia.FECHA_PAG,remesas_env_chile_bolivia.ESTADO, report_chile_bolivia.ESTADO_R FROM remesas_env_chile_bolivia INNER JOIN report_chile_bolivia ON remesas_env_chile_bolivia.CODIGO = report_chile_bolivia.CODIGO_R WHERE remesas_env_chile_bolivia.ESTADO != report_chile_bolivia.ESTADO_R");
while ($datos_reporte = $consulta_reporte_alquiler->fetch_object()) {      

/*while ($datos_reporte = $consulta_reporte_alquiler->fetch_object()) {      
   }*/
$i = $i + 1;
/* TABLA */
$pdf->Cell(18, 10, utf8_decode("$i"), 1, 0, 'C', 0);
$pdf->Cell(20, 10, utf8_decode("$datos_reporte"), 1, 0, 'C', 0);
$pdf->Cell(30, 10, utf8_decode("$datos_reporte"), 1, 0, 'C', 0);
$pdf->Cell(25, 10, utf8_decode("$datos_reporte"), 1, 0, 'C', 0);
$pdf->Cell(70, 10, utf8_decode("$datos_reporte"), 1, 0, 'C', 0);
$pdf->Cell(25, 10, utf8_decode("$datos_reporte"), 1, 1, 'C', 0);
}

$pdf->Output('Prueba.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
