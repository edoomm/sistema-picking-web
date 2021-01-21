<?php
    include_once "../db.php";
    $sku = $_POST["sku"];
    $id_linea = $_POST['id_linea'];
    $generico = $_POST['generico'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];
    $unidad_medida = $_POST['medida']; 
    $ubicacion = $_POST['ubicacion'];
    $flag = FALSE;
    $link = open_database();
    echo $sku;
    $sql_query = "INSERT INTO Producto (sku, id_linea, generico, unidad_medida, descripcion,stock,ubicacion) VALUES('".$sku."','".$id_linea."','".$generico."','".$unidad_medida."','".$descripcion."','".$stock."','".$ubicacion."')";
    echo $sql_query;
    $result = $link->query($sql_query);
    $link->close();

?>