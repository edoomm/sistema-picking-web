<?php
  include_once "../db.php";

    $sku = $_POST["sku"];
    $id_linea = $_POST['id_linea'];
    $generico = $_POST['generico'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $unidad_medida = $_POST['medida'];
    $flag = FALSE;
    $conn = open_database();
    $sql_query = "UPDATE Producto SET id_linea='".$id_linea."',generico='".$generico."',unidad_medida='".$unidad_medida."',descripcion='".$descripcion."',stock='".$stock."' WHERE sku='".$sku."'";
    $resultado = mysqli_query($conn,$sql_query);
    if($resultado)
    {
        echo "EXITO";
    }
    else
    {
        echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
    }
    mysqli_close($conn);
?>
