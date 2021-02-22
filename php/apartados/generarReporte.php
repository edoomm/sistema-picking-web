<?php
include_once '../db.php';
$datos = array();
$datos['archivo'] = "ALMACEN,CONTROL_DIST,CANT_CONTROL,CANT_RECOLECTADO\n";
$datos['error'] = array();
$sql_query = "SELECT control_id, cantidad FROM Transaccion WHERE tipo_movimiento='P' AND Date(hora_realizada)=CURDATE()";
$conn = open_database();
$transacciones = array();
$act = 0;
if(($result=mysqli_query($conn,$sql_query))!==FALSE){
    while($fila = mysqli_fetch_array($result)){
        $sku = $fila["control_id"];
        if(isset($transacciones[$sku])){
            $transacciones[$sku] += abs(intval($fila["cantidad"]));
        } 
        else{
            $transacciones[$sku] = abs(intval($fila["cantidad"]));
        }
    }
}
else{
    array_push($datos['error'], "Error " . mysqli_errno($conn) . " : " . mysqli_error($conn));
}
$esq_query = "SELECT id_sucursal, numero_control, apartado FROM Control WHERE control_id=";
foreach($transacciones as $control_id => $valor){
    $sql_query = $esq_query . "'". $control_id . "'";
    if(($result = mysqli_query($conn,$sql_query))!==FALSE){
        while($fila=mysqli_fetch_row($result)){
            foreach($fila as $elem){
                $datos['archivo'] .= $elem . ",";
            }
            $datos['archivo'] .= strval($valor). "\n";
        }
    }
}
//array_push($datos['error'], "Error " . mysqli_errno($conn) . " : " . mysqli_error($conn));
echo json_encode($datos);
?>