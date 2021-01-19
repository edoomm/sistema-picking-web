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
    $sql_query = "UPDATE Producto SET id_linea='".$id_linea."',generico='".$generico."',unidad_medida='".$unidad_medida."',descripcion='".$descripcion."',stock='".$stock."',ubicacion='".$ubicacion."' WHERE sku='".$sku."'";
    $result = $link->query($sql_query);
    $link->close();
?>
