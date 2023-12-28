<?php
require_once("menu.php");
$cantidad = 0;
include("conexion.php");
//$sql = "SELECT remesas_env_chile_bolivia.CODIGO, report_chile_bolivia.CODIGO_R , remesas_env_chile_bolivia.FECHA, report_chile_bolivia.FECHA_ORI,report_chile_bolivia.FECHA_PAG,remesas_env_chile_bolivia.ESTADO, report_chile_bolivia.ESTADO_RFROM remesas_env_chile_bolivia INNER JOIN report_chile_bolivia ON remesas_env_chile_bolivia.CODIGO = report_chile_bolivia.CODIGO_R WHERE remesas_env_chile_bolivia.ESTADO = report_chile_bolivia.ESTADO_R AND remesas_env_chile_bolivia.ESTADO = 'PAGADO'";
//$resultadoMCB=mysqli_query($conexion,$sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!--Boostrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
     <!--  Datatables  -->
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
    <!--  Datatables Responsive  -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        thead{
            background-color: #F38E2E;
            color: #FFF;
        }
    </style>
    
</head>
<body> 
<div class="text-right">
        <!--hacemos que los datos de los canlendarios se guaden y puedan ser re usados-->
        <a href="ReportePDF/PDFconsulta2.php?from_date=<?php echo $_GET['from_date']; ?>&to_date=<?php echo $_GET['to_date']; ?>" target="_blank" class ="btn btn-success">
        <i class="far fa-file-pdf"></i> Generar Reporte</a>
    </div>
    <h1 class="text-center">Consulta 2</h1>
    <div class="container">

        <form action="" method="GET">
            <div class="row">                                     
                <div class="col-md-4">

                <div class="form-group">
                    <label><b>Del Dia</b></label>
                    <input type="date" name="from_date" value="<?php if(date(isset($_GET['from_date']))){ echo $_GET['from_date']; } ?>" class="form-control">
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group">                                       
                    <label><b> Hasta  el Dia</b></label>
                    <input type="date" name="to_date" value="<?php if(isset($_GET['to_date'])){ echo $_GET['to_date']; } ?>" class="form-control">
                </div>
            </div>
     
            <div class="col-md-4">       
                <div class="form-group">
                    <label>
                        <b></b>
                    </label> 
                    <br>
                    <br>    <button type="submit" class="btn btn-secondary">Buscar</button>
                </div>
            </div>
            </div>
            <br>
        </form>
        <div class="row">
            <div class="col-lg-12">
            <table id="remesasCB" class="table table-border table-hover" cellspacing="0" width ="100%">
                <thead>
                    <tr>
                        <!--<th>NUM</th>-->
                        <th>N°</th>
                        <th>CODIGO T1</th>
                        <th>CODIGO T2</th>
                        <th>FECHA ENVIO T1</th>
                        <th>FECHA ENVIO T2</th>
                        <th>FECHA PAGO</th>
                        <th>ESTADO T1</th>
                        <th>ESTADO T2</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if(isset($_GET['from_date']) && isset($_GET['to_date'])){
                    $from_date = $_GET['from_date'];
                    $to_date = $_GET['to_date'];
                    $query ="SELECT remesas_env_chile_bolivia.CODIGO, 
                    report_chile_bolivia.CODIGO_R , remesas_env_chile_bolivia.FECHA, 
                    report_chile_bolivia.FECHA_ORI,report_chile_bolivia.FECHA_PAG,remesas_env_chile_bolivia.ESTADO, 
                    report_chile_bolivia.ESTADO_R
                    FROM remesas_env_chile_bolivia 
                    INNER JOIN report_chile_bolivia 
                    ON remesas_env_chile_bolivia.CODIGO = report_chile_bolivia.CODIGO_R 
                    WHERE remesas_env_chile_bolivia.ESTADO = report_chile_bolivia.ESTADO_R
                     AND remesas_env_chile_bolivia.ESTADO = 'PAGADO' AND DATE(FECHA) BETWEEN '$from_date' AND '$to_date'";
                    $query_run = mysqli_query($conexion, $query);
                    if(mysqli_num_rows($query_run) > 0){
                        foreach($query_run as $fila){?>
                        <?php $cantidad = $cantidad + 1 ?>
                        <tr>
                            <td><?php echo $cantidad; ?></td>
                            <td> <?php echo $fila['CODIGO'] ?> </td>
                            <td> <?php echo $fila['CODIGO_R'] ?> </td>
                            <td> <?php echo date("d-m-Y", strtotime($fila['FECHA'])) ?> </td>
                            <td> <?php echo date("d-m-Y", strtotime($fila['FECHA_ORI'])) ?> </td>
                            <td> <?php echo date("d-m-Y", strtotime($fila['FECHA_PAG'])) ?> </td>
                            <td> <?php echo $fila['ESTADO'] ?> </td>
                            <td> <?php echo $fila['ESTADO_R'] ?> </td>
                        </tr>                        
                <?php
                        }
                    }else{?>
                <tr>
                    <td><?php  echo "No se encontraron resultados"; ?></td>
                    <?php }                                
                } ?>  
                </tbody>
            </table>
            <?php  mysqli_close($conexion); ?>
            </div>
        </div>
    </div>

    <!--Boostrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <!-- Datatables-->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>  
    <!-- Datatables responsive -->
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <!--comandos js-->
    <script>
        $(document).ready(function(){
            $('#remesasCB').DataTable({
                responsive: true
            });
        });
    </script>
</body>
</html>