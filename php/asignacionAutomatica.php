<?php
include_once 'db.php';
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
$sql_query_control = "SELECT id_sucursal, control_id, apartado FROM Control WHERE asignado='1'";
$sql_query_asigned = "UPDATE Control SET asignado = '1' WHERE asignado='0'";
$sql_query_empledo = "SELECT num_empleado FROM Operador";
$cantidad_de_productos = 0;
$cont = 0;
$controles = array();
$empleados = array();
$ticket = array();
mysqli_query($conn,$sql_query_asigned);
if(($result1 = mysqli_query($conn, $sql_query_control))!==FALSE){
    while(($fila1 = mysqli_fetch_row($result1))){
        $cantidad_de_productos += $fila1[2];
        $controles[$cont] = $fila1;
        $ticket[$fila1[0]] += $fila1[2];
        $cont++;
    }
}
$cont = 0;
if(($result2 = mysqli_query($conn, $sql_query_empledo))!==FALSE){
    while($fila2 = mysqli_fetch_row($result2)){
        $empleados[$cont] = $fila2[0];
        $cont++;
    }
}
$productos_por_empleado = round($cantidad_de_productos/count($empleados));
$cont = 0;
foreach($empleados as $aux){
    $lleva_empleado = 0;
    foreach($ticket as $clave => $valor){
        $lleva_empleado += $valor;
        $controles_sucursal = get_controles($clave,$conn);
        foreach($controles_sucursal as $id_control){
            $query = "INSERT INTO Operador_has_control (control_id, num_empleado, prioridad) VALUES ('".$id_control."','".$aux."','1')";
            if(mysqli_query($conn, $query)!==TRUE){
                echo "Error 3\n";
            }
        }
        unset($ticket[$clave]);
        if($lleva_empleado >= $productos_por_empleado){
            echo "num_empleado: " . $aux . " lleva: " . $lleva_empleado . "\n";
            break;
        }
    }
}
mysqli_close($conn);
?>