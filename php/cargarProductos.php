<?php
include 'db.php';
include 'leerCSV.php';
if(isset($_FILES['file_name'])){
/*
    En las filas del archivo csv
    0 -> SKU
    1 -> Linea
    2 -> Generico
    3 -> Descripcion
    4 -> Stock 
<<<<<<< HEAD
    5 -> Ubicacion
=======
>>>>>>> f360a43d00462447d698b8a4cf32ca7aa8644e36
*/
    $datos = obtener_contenido();
    if($datos !== FALSE)
    {
        $con = open_database();
        foreach($datos as $fila){
            $sku = $fila[0];
            $id_linea = $fila[1];
            $generico = $fila[2];
            $descripcion = $fila[3];
            $stock = $fila[4];
            $unidad_medida = 1; 
<<<<<<< HEAD
            $ubicacion = "SIN ASIGNAR";
            $sql_query = "INSERT INTO Producto (sku, id_linea, generico, unidad_medida, descripcion,stock,ubicacion) VALUES('".$sku."','".$id_linea."','".$generico."','".$unidad_medida."','".$descripcion."','".$stock."','".$ubicacion."')";
=======
            $sql_query = "INSERT INTO Producto (sku, id_linea, generico, unidad_medida, descripcion,stock) VALUES('".$sku."','".$id_linea."','".$generico."','".$unidad_medida."','".$descripcion."','".$stock."')";
>>>>>>> f360a43d00462447d698b8a4cf32ca7aa8644e36
            mysqli_query($con, $sql_query);
        }
        mysqli_close($con);
    }
}
else
{
    echo "ERROR_ARCHIVO";
}
?>