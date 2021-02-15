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
    $link = open_database();
    $sql_query = "INSERT INTO Producto (sku, id_linea, generico, unidad_medida, descripcion,stock,ubicacion) VALUES('".$sku."','".$id_linea."','".$generico."','".$unidad_medida."','".$descripcion."','".$stock."','".$ubicacion."')";
    $result = $link->query($sql_query);
    $link->close();

?>