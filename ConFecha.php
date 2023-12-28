<?php
 include("conexion.php");
?>

<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
     <!--  Datatables  -->
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
    <!--  Datatables Responsive  -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

    <link rel="stylesheet" href="../css/es.css">

    <title>Usuarios</title>
</head>
<br>
<div class="container is-fluid">
    <div class="col-xs-12">
        <h2>BUSCADOR POR FECHA CON PHP</h2> <!--pruevaa-->
        <br>
        <div>
            <style>	th {
                font-weight: bold;
                color: white;}
            </style>

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
                <b>

            </b>
        </label> 
        <br>
        <br>    <button type="submit" class="btn btn-secondary">Buscar</button>
        </div>
    </div>
    </div>
<br>
</form>
<table class="table table-striped" id= "table_id">
    <thead>
        <tr class="bg-dark">
        <th>N°</th>
        <th>CODIGO</th>
        <th>FECHA</th>
        <th>ESTADO</th>
        <th>AIR</th>
        <th>AGR</th>
        <th>OPE</th>
        <th>ORIGEN</th>
        <th>CRD</th>
        <th>DESTINO</th>
        <th>MONEDA</th>
        <th>MONTO</th>
        <th>COMISION_POR</th>
        <th>COMISION_CRL</th>
        <th>REIBIDO_USD</th>
        <th>RECIBIDO_CLP</th>
        <th>TOTAL_CLP</th>
        <th>REMITENTE</th>
        <th>DESTINATARIO</th>

        </tr>
    </thead>
    <tbody>

<?php 
    if(isset($_GET['from_date']) && isset($_GET['to_date'])){
        $from_date = $_GET['from_date'];
        $to_date = $_GET['to_date'];
        $query ="SELECT * 
        FROM remesas_env_chile_bolivia 
        WHERE DATE(FECHA) BETWEEN '$from_date' AND '$to_date';";
        $query_run = mysqli_query($conexion, $query);
        if(mysqli_num_rows($query_run) > 0){
            foreach($query_run as $fila){
?>
        <tr>
            <td> <?php echo $fila['ID'] ?> </td>
            <td> <?php echo $fila['CODIGO'] ?> </td>
            <td> <?php echo date("d-m-Y h:i", strtotime($fila['FECHA'])) ?> </td>                          
            <td> <?php echo $fila['ESTADO'] ?> </td>
            <td> <?php echo $fila['AIR'] ?> </td>
            <td> <?php echo $fila['AGR'] ?> </td>
            <td> <?php echo $fila['OPE'] ?> </td>
            <td> <?php echo $fila['ORIGEN'] ?> </td>
            <td> <?php echo $fila['CRD'] ?> </td>
            <td> <?php echo $fila['DESTINO'] ?> </td>
            <td> <?php echo $fila['MONEDA'] ?> </td>
            <td> <?php echo $fila['MONTO'] ?> </td>
            <td> <?php echo $fila['COMISION_POR'] ?> </td>
            <td> <?php echo $fila['COMISION_CLP'] ?> </td>
            <td> <?php echo $fila['RECIBIDO_USD'] ?> </td>
            <td> <?php echo $fila['RECIBIDO_CLP'] ?> </td>
            <td> <?php echo $fila['TOTAL_CLP'] ?> </td>
            <td> <?php echo $fila['REMITENTE'] ?> </td>
            <td> <?php echo $fila['DESTINATARIO']  ?> </td>
    <!--<td><img src="../imgs/<?php echo $fila['imagen']; ?>" 
    onerror=this.src="../imgs/noimage.png" width="50" heigth="70"></td>-->
        </tr>
        <?php
            }
        }
        else{
        ?>
        <tr>
            <td><?php  echo "No se encontraron resultados"; ?></td>
        <?php }                                
        } ?>
    </div>
</html>