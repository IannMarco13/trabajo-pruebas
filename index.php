<?php
    require_once("menu.php");
    if (isset($_POST["enviar2"])) {

    require_once("conexion.php");
    require_once("funtions.php");
    //Datos reporte remesas chile bolivia
    $archivoBC = $_FILES["archivoBC"]["name"];
    $archivo_copiadoBC = $_FILES["archivoBC"]["tmp_name"];
    $archivo_guardadoBC = "copia_".$archivoBC;

    if (copy($archivo_copiadoBC, $archivo_guardadoBC)) {
        echo "Se copio correctamente el archivo temmporal a nuestra carpeta <br/>";
    }else{
        echo"Error en el copiado <br/>";
    }
    if(file_exists($archivo_guardadoBC)) {
        $fp = fopen($archivo_guardadoBC,"r");
        while ($datos = fgetcsv($fp,1000,";")) {
    
            $fecha_convertida_2 = ($datos[2] === '-' || empty($datos[2])) ? NULL : DateTime::createFromFormat('d-m-Y H:i:s', $datos[2]);
            $fecha_convertida_5 = ($datos[5] === '-' || empty($datos[5])) ? NULL : DateTime::createFromFormat('d-m-Y H:i:s', $datos[5]);

            if ($fecha_convertida_2) {
                $fecha_convertida_2 = $fecha_convertida_2->format('Y-m-d H:i:s');
            }
            if ($fecha_convertida_5) {
                $fecha_convertida_5 = $fecha_convertida_5->format('Y-m-d H:i:s');
            }
            // Transformar valores decimales (12,3)
            $decimal_7 = str_replace(".", "", $datos[7]); // Eliminar puntos de los miles
            $decimal_7 = str_replace(",", ".", $decimal_7); // Reemplazar comas por puntos
            $decimal_7 = floatval($decimal_7); // Convertir a float

            $decimal_8 = str_replace(".", "", $datos[8]); // Eliminar puntos de los miles
            $decimal_8 = str_replace(",", ".", $decimal_8); // Reemplazar comas por puntos
            $decimal_8 = floatval($decimal_8); // Convertir a float

            // Redondear a 3 decimales si es necesario
            $decimal_7 = number_format($decimal_7, 3, '.', '');
            $decimal_8 = number_format($decimal_8, 3, '.', '');
    
            // Llamar a la función de inserción con la fecha convertida
            $resultadoBC = insertar_datos2($conexion,$datos[0], $datos[1], $fecha_convertida_2, $datos[3], $datos[4], $fecha_convertida_5, $datos[6], $decimal_7, $decimal_8, $datos[9], $datos[10]);

            /*if($resultadoBC) {
                echo "Se inserto correctamente la segunda tabla <br/>";
            }else{
                echo "No se inserto la tabla <br/>";
            }*/
        }
    }else{
        echo "No existe el archivo copiado <br/>";
    }   
}
if (isset($_POST["enviar3"])) {//permite recepcionar una variable que si exista y que no sea null
    
    require_once("conexion.php");
    require_once("funtions.php");

    //Datos remesas Chile Bolivia
    $archivoP = $_FILES["archivoP"]["name"];
    $archivo_copiadoP = $_FILES["archivoP"]["tmp_name"];
    $archivo_guardadoP = "copia_".$archivoP;
    
    //echo $archivo. "esta en la ruta temporal: " .$archivo_copiado;

    if (copy($archivo_copiadoP, $archivo_guardadoP)) {
        $alert = "Se copio correctamente el archivo temmporal a nuestra carpeta";
        //echo "Se copio correctamente el archivo temmporal a nuestra carpeta <br/>";
    }else{
        echo"Error en el copiado <br/>";
    }

    if(file_exists($archivo_guardadoP)) {
        $fp = fopen($archivo_guardadoP,"r");
        
        while ($datos = fgetcsv($fp,1000,";")) {

            $fecha_convertida_1 = date('Y-m-d H:i:s', strtotime(str_replace('-', '-', $datos[1])));
            $datos[1] = $fecha_convertida_1;

            // Transformar valores decimales (12,3)
            $decimal_10 = str_replace(".", "", $datos[10]); // Eliminar puntos de los miles
            $decimal_10 = str_replace(",", ".", $decimal_10); // Reemplazar comas por puntos
            $decimal_10 = floatval($decimal_10); // Convertir a float

            $decimal_11 = str_replace(".", "", $datos[11]); // Eliminar puntos de los miles
            $decimal_11 = str_replace(",", ".", $decimal_11); // Reemplazar comas por puntos
            $decimal_11 = floatval($decimal_11); // Convertir a float

            $decimal_12 = str_replace(".", "", $datos[12]); // Eliminar puntos de los miles
            $decimal_12 = str_replace(",", ".", $decimal_12); // Reemplazar comas por puntos
            $decimal_12 = floatval($decimal_12); // Convertir a float

            $decimal_13 = str_replace(".", "", $datos[13]); // Eliminar puntos de los miles
            $decimal_13 = str_replace(",", ".", $decimal_13); // Reemplazar comas por puntos
            $decimal_13 = floatval($decimal_13); // Convertir a float

            $decimal_14 = str_replace(".", "", $datos[14]); // Eliminar puntos de los miles
            $decimal_14 = str_replace(",", ".", $decimal_14); // Reemplazar comas por puntos
            $decimal_14 = floatval($decimal_14); // Convertir a float

            $decimal_15 = str_replace(".", "", $datos[15]); // Eliminar puntos de los miles
            $decimal_15 = str_replace(",", ".", $decimal_15); // Reemplazar comas por puntos
            $decimal_15 = floatval($decimal_15); // Convertir a float

            // Redondear a 3 decimales si es necesario
            $decimal_10 = number_format($decimal_10, 3, '.', '');
            $decimal_11 = number_format($decimal_11, 3, '.', '');
            $decimal_12 = number_format($decimal_12, 3, '.', '');
            $decimal_13 = number_format($decimal_13, 3, '.', '');
            $decimal_14 = number_format($decimal_14, 3, '.', '');
            $decimal_15 = number_format($decimal_15, 3, '.', '');
    
            
            $resultadoP = insertar_datos1($conexion,$datos[0], $datos[1], $datos[2], $datos[3], $datos[4], $datos[5], $datos[6], $datos[7], $datos[8], $datos[9], $decimal_10, $decimal_11, $decimal_12, $decimal_13, $decimal_14, $decimal_15, $datos[16], $datos[17]);
                //if($resultadoCB) {
                  //  echo "Se inserto correctamente la segunda tabla <br/>";
                //}else{
                   // echo "No se inserto la tabla <br/>";
                //}
        }
            
    }else{
        echo "No existe el archivo copiado <br/>";
    }
}

if (isset($_POST["enviar4"])) {//permite recepcionar una variable que si exista y que no sea null
    
    require_once("conexion.php");
    require_once("funtions.php");

    //Datos remesas Chile Bolivia
    $archivoB = $_FILES["archivoB"]["name"];
    $archivo_copiadoB = $_FILES["archivoB"]["tmp_name"];
    $archivo_guardadoB = "copia_".$archivoB;
    
    //echo $archivo. "esta en la ruta temporal: " .$archivo_copiado;

    if (copy($archivo_copiadoB, $archivo_guardadoB)) {
        $alert = "Se copio correctamente el archivo temmporal a nuestra carpeta";
        //echo "Se copio correctamente el archivo temmporal a nuestra carpeta <br/>";
    }else{
        echo"Error en el copiado <br/>";
    }

    if(file_exists($archivo_guardadoB)) {
        $fp = fopen($archivo_guardadoB,"r");
        
        while ($datos = fgetcsv($fp,1000,";")) {

            $fecha_convertida_1 = ($datos[1] === '-' || empty($datos[1])) ? NULL : DateTime::createFromFormat('d-m-Y H:i:s', $datos[1]);
            $fecha_convertida_19 = ($datos[19] === '-' || empty($datos[19])) ? NULL : DateTime::createFromFormat('d-m-Y H:i:s', $datos[9]);

            if ($fecha_convertida_1) {
                $fecha_convertida_1 = $fecha_convertida_1->format('Y-m-d H:i:s');
            }
            if ($fecha_convertida_19) {
                $fecha_convertida_19 = $fecha_convertida_19->format('Y-m-d H:i:s');
            }

            // Transformar valores decimales (12,3)
            $decimal_12 = str_replace(".", "", $datos[12]); // Eliminar puntos de los miles
            $decimal_12 = str_replace(",", ".", $decimal_12); // Reemplazar comas por puntos
            $decimal_12 = floatval($decimal_12); // Convertir a float

            $decimal_13 = str_replace(".", "", $datos[13]); // Eliminar puntos de los miles
            $decimal_13 = str_replace(",", ".", $decimal_13); // Reemplazar comas por puntos
            $decimal_13 = floatval($decimal_13); // Convertir a float

            $decimal_14 = str_replace(".", "", $datos[14]); // Eliminar puntos de los miles
            $decimal_14 = str_replace(",", ".", $decimal_14); // Reemplazar comas por puntos
            $decimal_14 = floatval($decimal_14); // Convertir a float

            $decimal_15 = str_replace(".", "", $datos[15]); // Eliminar puntos de los miles
            $decimal_15 = str_replace(",", ".", $decimal_15); // Reemplazar comas por puntos
            $decimal_15 = floatval($decimal_15); // Convertir a float

            $decimal_16 = str_replace(".", "", $datos[16]); // Eliminar puntos de los miles
            $decimal_16 = str_replace(",", ".", $decimal_16); // Reemplazar comas por puntos
            $decimal_16 = floatval($decimal_16); // Convertir a float

            $decimal_17 = str_replace(".", "", $datos[17]); // Eliminar puntos de los miles
            $decimal_17 = str_replace(",", ".", $decimal_17); // Reemplazar comas por puntos
            $decimal_17 = floatval($decimal_17); // Convertir a float

            $decimal_18 = str_replace(".", "", $datos[18]); // Eliminar puntos de los miles
            $decimal_18 = str_replace(",", ".", $decimal_18); // Reemplazar comas por puntos
            $decimal_18 = floatval($decimal_18); // Convertir a float

            // Redondear a 3 decimales si es necesario
            $decimal_12 = number_format($decimal_12, 2, '.', '');
            $decimal_13 = number_format($decimal_13, 2, '.', '');
            $decimal_14 = number_format($decimal_14, 2, '.', '');
            $decimal_15 = number_format($decimal_15, 2, '.', '');
            $decimal_16 = number_format($decimal_16, 2, '.', '');
            $decimal_17 = number_format($decimal_17, 2, '.', '');
            $decimal_18 = number_format($decimal_18, 2, '.', '');
            
            $resultadoB = insertar_datos3($conexion,$datos[0], $fecha_convertida_1, $datos[2], $datos[3], $datos[4], $datos[5], $datos[6], $datos[7], $datos[8], $datos[9], $datos[10], $datos[11], $decimal_12, $decimal_13, $decimal_14, $decimal_15,$decimal_16,$decimal_17,$decimal_18, $fecha_convertida_19, $datos[20]);
                //if($resultadoB) {
                  //echo "Se inserto correctamente la segunda tabla <br/>";
                //}else{
                  //  echo "No se inserto la tabla <br/>";
                //}
        }
            
    }else{
        echo "No existe el archivo copiado <br/>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>menu</title>
    <!--Boostrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
     <!--  Datatables  -->
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
    <!--  Datatables Responsive  -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="menu.php">

</head>
<body>
    <!--Boostrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <!-- Datatables-->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>  
    <!-- Datatables responsive -->
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<br><br>
    <div class="formulario">
         <form action="index.php" class="formulariocompleto" method="post" enctype="multipart/form-data">
            <input type="file" name="archivoP" class="form"/>
            <input type="submit" value="Subir Archvo Remesas" class="form" name="enviar3">
        </form>
    </div>
<div>
    <div>
        <div>
        <form action="index.php" class="formulariocompleto" method="post" enctype="multipart/form-data">        
            <input type="file" name="archivoBC" class="form"/>
            <input type="submit" value="Subir Archvo Reportes" class="form" name="enviar2">
        </form>
        </div>
    </div>
    <div>
        <form action="index.php" class="formulariocompleto" method="post" enctype="multipart/form-data">        
            <input type="file" name="archivoB" class="form"/>
            <input type="submit" value="Subir Archvo Reportes" class="form" name="enviar4">
        </form>
        </div>
</div>
        
    
</body>
</html>
