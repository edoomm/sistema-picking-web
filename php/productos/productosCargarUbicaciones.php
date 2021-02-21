<?php
include '../db.php';
$con = open_database();
$sku = $_POST["sku"];
$respax = [];
$query = "SELECT ubicacion FROM Ubicacion WHERE sku='".$sku."'";
$resultado = mysqli_query($con,$query);
if($resultado)
{
    $respax["numUbicaciones"] = mysqli_num_rows($resultado);
    $i = 1;
    while($fila = mysqli_fetch_row($resultado))
    {
        $id = "ubicacion".strval($i);
        $respax[$id] = $fila[0];
        $i++;
    }
    $respax["mensaje"] = "EXITO";
}
else
{
    $respax["mensaje"] = "Error ".mysqli_errno($con)." : ".mysqli_error($con)."\n";
}
mysqli_close($con);
 echo json_encode($respax);
?>