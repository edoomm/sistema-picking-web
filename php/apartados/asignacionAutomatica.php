<?php
include_once '../db.php';
function get_controles($id_sucursal, $conn){
    $cont = 0;
    $ret = array();
    $sql_query = "SELECT control_id FROM Control WHERE id_sucursal='". $id_sucursal ."'";
    $result=mysqli_query($conn,$sql_query);
    while(($fila=mysqli_fetch_row($result))){
        $ret[$cont] = $fila[0];
        $cont++;
    }
    return $ret;
}
$conn = open_database();
$sql_query_control = "SELECT id_sucursal, control_id, apartado FROM Control WHERE estado=0";
$sql_query_asigned = "UPDATE Control SET estado = 1 WHERE estado=0";
$cantidad_de_productos = 0;
$cont = 0;
$controles = array();
$empleados = json_decode($_POST['operadores']);
$ticket = array();
if(($result1 = mysqli_query($conn, $sql_query_control))!==FALSE){
    while(($fila1 = mysqli_fetch_row($result1))){
        $cantidad_de_productos += $fila1[2];
        $controles[$cont] = $fila1;
        $ticket[$fila1[0]] += $fila1[2];
        $cont++;
    }
}
mysqli_query($conn,$sql_query_asigned);
$productos_por_empleado = round($cantidad_de_productos/count($empleados));
$cont = 0;
foreach($empleados as $aux){
    $lleva_empleado = 0;
    foreach($ticket as $clave => $valor){
        $lleva_empleado += $valor;
        $controles_sucursal = get_controles($clave,$conn);
        foreach($controles_sucursal as $id_control){
            $query = "INSERT INTO Operador_has_control (control_id, num_empleado) VALUES ('".$id_control."','".$aux."')";
            if(mysqli_query($conn, $query)!==TRUE){
            }
        }
        unset($ticket[$clave]);
        if($lleva_empleado >= $productos_por_empleado){
            break;
        }
    }
}
mysqli_close($conn);
?>