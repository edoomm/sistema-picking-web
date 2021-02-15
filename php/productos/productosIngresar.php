<?php
    include_once "../db.php";
    $sku = $_POST["sku"];
    $id_linea = $_POST['id_linea'];
    $generico = $_POST['generico'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $unidad_medida = $_POST['medida']; 
    $ubicacion = "SIN ASIGNAR";
    $flag = FALSE;
    $conn = open_database();
    $sql_query = "INSERT INTO Producto (sku, id_linea, generico, unidad_medida, descripcion,stock,ubicacion) VALUES('".$sku."','".$id_linea."','".$generico."','".$unidad_medida."','".$descripcion."','".$stock."','".$ubicacion."')";
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