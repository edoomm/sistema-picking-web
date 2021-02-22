<?php
include_once('./db.php');
$conn = open_database();
$query = $_POST['query'];
if(isset($_POST["tipo"]))
{
    $tipo = $_POST["tipo"];
}
else
{
    $tipo = 0;
}
$res = mysqli_query($conn,$query);
$rows = mysqli_fetch_all($res);
if($tipo == 1)
{
    if(strcmp($rows[0][2],"SIN ASIGNAR") != 0)
    {
        $sql_query = "SELECT ubicacion FROM Ubicacion WHERE sku=".$rows[0][0]."";
        $resultado = mysqli_query($conn,$sql_query);
        if(!$resultado)
        {
            exit(0);
        }
        $ubicacion = "";
        while($fila = mysqli_fetch_row($resultado))
        {
            $ubicacion = $ubicacion." ".$fila[0];
        }
        $rows[0][2] = $ubicacion;
    }
}
echo json_encode($rows);
mysqli_close($conn);
?>