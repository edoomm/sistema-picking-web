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
<<<<<<< HEAD
    5 -> Ubicacion
=======
>>>>>>> f360a43d00462447d698b8a4cf32ca7aa8644e36
=======
    5 -> Ubicacion
>>>>>>> e1f8949a5d1ac5db854e6b845982e744317384e7
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
<<<<<<< HEAD
            $ubicacion = "SIN ASIGNAR";
            $sql_query = "INSERT INTO Producto (sku, id_linea, generico, unidad_medida, descripcion,stock,ubicacion) VALUES('".$sku."','".$id_linea."','".$generico."','".$unidad_medida."','".$descripcion."','".$stock."','".$ubicacion."')";
=======
            $sql_query = "INSERT INTO Producto (sku, id_linea, generico, unidad_medida, descripcion,stock) VALUES('".$sku."','".$id_linea."','".$generico."','".$unidad_medida."','".$descripcion."','".$stock."')";
>>>>>>> f360a43d00462447d698b8a4cf32ca7aa8644e36
=======
            $ubicacion = "SIN ASIGNAR";
            $sql_query = "INSERT INTO Producto (sku, id_linea, generico, unidad_medida, descripcion,stock,ubicacion) VALUES('".$sku."','".$id_linea."','".$generico."','".$unidad_medida."','".$descripcion."','".$stock."','".$ubicacion."')";
>>>>>>> e1f8949a5d1ac5db854e6b845982e744317384e7
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