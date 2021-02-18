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
    5 -> Ubicacion
*/
    $datos = obtener_contenido();
    $bandera = true;
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
            $ubicacion = "SIN ASIGNAR";
            $sql_query = "INSERT INTO Producto (sku, id_linea, generico, unidad_medida, descripcion,stock,ubicacion) VALUES('".$sku."','".$id_linea."','".$generico."','".$unidad_medida."','".$descripcion."','".$stock."','".$ubicacion."')";
            $resultado = mysqli_query($con, $sql_query);
            if(!$resultado)
            {
                echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
            }
        }
        if($bandera)
            echo "EXITO";
        mysqli_close($con);
    }
}
else
{
    echo "ERROR_ARCHIVO";
}
?>