<?php
include 'db.php';
include 'leerCSV.php';
if(isset($_FILES['file_name'])){
/*
    En las filas del archivo csv
    0 -> id_linea
    1 -> sku
    2 -> descripcion
    3 -> generico 
*/
    $datos = obtener_contenido();
    $conn = open_database();
    foreach($datos as $fila){
        $id_linea = $fila[0];
        $sku = $fila[1];
        $descripcion = $fila[2];
        $generico = $fila[3];
        $unidad_medida = 1; 
        $sql_query = "INSERT INTO Producto (sku, id_linea, generico, unidad_medida, descripcion) VALUES('".$sku."','".$id_linea."','".$generico."','".$unidad_medida."','".$descripcion."')";
        echo $sql_query . "\n";
        mysqli_query($conn, $sql_query);
    }
    mysqli_close($con);
}
?>