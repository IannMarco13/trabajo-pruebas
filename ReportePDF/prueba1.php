<?php

include('pdf_mc_table.php');
require_once ('../conexion.php');
$i=0;
// Crear un nuevo objeto $pdf
$pdf = new PDF_MC_Table();

// Agregar una página y establecer la fuente
$pdf->AddPage('landscape');
$pdf->SetFont('times', '', 8);

// Establecer el ancho para cada columna (13 columnas)
$pdf->SetWidths([8,12,12,12,12,25,10,15,8,13,18,55,68]);

// Establecer la altura de línea. Esto es la altura de cada línea, no las filas.
$pdf->SetLineHeight(5);

$query = ("SELECT remesas_env_chile_bolivia.AIR, remesas_env_chile_bolivia.AGR, remesas_env_chile_bolivia.CRD, remesas_env_chile_bolivia.CODIGO, remesas_env_chile_bolivia.FECHA , remesas_env_chile_bolivia.RECIBIDO_USD, remesas_env_chile_bolivia.RECIBIDO_CLP, remesas_env_chile_bolivia.MONEDA,remesas_env_chile_bolivia.MONTO,remesas_env_chile_bolivia.ESTADO, remesas_env_chile_bolivia.REMITENTE, remesas_env_chile_bolivia.DESTINATARIO FROM remesas_env_chile_bolivia WHERE DATE(FECHA) BETWEEN '2023-12-06' AND '2023-12-06'");
// Recorrer los datos
$query_run = mysqli_query($conexion, $query);
if(mysqli_num_rows($query_run) > 0){
   foreach($query_run as $fila){   
        $i = $i + 1;
        /* FILA */
        $pdf->Row([
            $i,
            $fila['AIR'],
            $fila['AGR'],
            $fila['CRD'],
            $fila['CODIGO'],
            date('d-m-Y h:i', strtotime($fila['FECHA'])),
            number_format($fila['RECIBIDO_USD'], 0),
            number_format($fila['RECIBIDO_CLP'], 0),
            $fila['MONEDA'],
            number_format($fila['MONTO'], 0),
            $fila['ESTADO'],
            $fila['REMITENTE'],
            $fila['DESTINATARIO']
        ]);
    }
}

// Mostrar el PDF
$pdf->Output();
