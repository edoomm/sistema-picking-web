<?php
include_once '../db.php';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="reporte.csv"');
$cols_archivo[0] = array('ALMACEN','SKU','CONTROL_DIST','CANT_CONTROL','CANT_RECOLECTADO');
$sql_query = "SELECT control_id, cantidad FROM Transaccion WHERE tipo_movimiento='P' AND Date(hora_realizada)=CURDATE()";
$conn = open_database();
$transacciones = array();
$act = 0;
if(($result=mysqli_query($conn,$sql_query))!==FALSE){
    while($fila = mysqli_fetch_row($result)){
        $transacciones[$fila[0]] += $fila[1];
    }
}
$esq_query = "SELECT id_sucursal, sku, numero_control, apartado FROM Control WHERE control_id=";
$fp = fopen("php://output", 'wb');
fputcsv($fp,$cols_archivo[0], ',');
foreach($transacciones as $control_id => $valor){
    $sql_query = $esq_query . "'". $control_id . "'";
    if(($result = mysqli_query($conn,$sql_query))!==FALSE){
        while($fila=mysqli_fetch_row($result)){
            array_push($fila, $valor);
            fputcsv($fp,$fila,',');
        }
    }
}
?>