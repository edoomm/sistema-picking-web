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
            $sql_busqueda = "SELECT sku FROM Producto WHERE sku = '".$sku."'";
            $resultado = mysqli_query($con,$sql_busqueda);
            if($resultado)
            {
                $fila = mysqli_fetch_row($resultado);
                if($fila != NULL)
                {
                    $sql_query = "UPDATE Producto SET id_linea='".$id_linea."',generico ='".$generico."',unidad_medida='".$unidad_medida."',descripcion='".$descripcion."',stock='".$stock."',ubicacion='".$ubicacion."' WHERE sku='".$sku."'";
                    $resultado = mysqli_query($con,$sql_query);
                    if(!$resultado)
                    {
                        $bandera = false;
                        echo "Error ".mysqli_errno($con)." : ".mysqli_error($con)."\n";
                    }
                }
                else
                {
                    $sql_query = "INSERT INTO Producto (sku, id_linea, generico, unidad_medida, descripcion,stock,ubicacion) VALUES('".$sku."','".$id_linea."','".$generico."','".$unidad_medida."','".$descripcion."','".$stock."','".$ubicacion."')";
                    $resultado = mysqli_query($con, $sql_query);
                    if(!$resultado)
                    {
                        $bandera = false;
                        echo "Error ".mysqli_errno($con)." : ".mysqli_error($con)."\n";
                    }
                }
            }
            else
            {
                $bandera = false;
                echo "Error ".mysqli_errno($con)." : ".mysqli_error($con)."\n";
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