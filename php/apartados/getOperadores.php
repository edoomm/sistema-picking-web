<?php
include_once '../db.php';
$conn = open_database();
$sql_query = "SELECT num_empleado,nombre  FROM Operador";
$result = array();
if(($res=mysqli_query($conn,$sql_query))!==FALSE){
    while($fila=mysqli_fetch_row($res)){
        $num_operador = $fila[0];
        $nombre = $fila[1];
        array_push($result,$num_operador."-".$nombre);
    }
    echo json_encode($result);
}
?>