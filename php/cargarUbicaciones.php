<?php
include 'db.php';
include 'leerCSV.php';
if(isset($_FILES['file_name'])){
/*
    En las filas del archivo csv
    0 -> Ubicacion
    1 -> SKU
    2 -> Pasillo
    3 -> Rack
    4 -> Columna
    5 -> Nivel
    6 -> Prioridad 
*/
    $datos = obtener_contenido();
    $bandera = true;
    $bandera2 = true;
    if($datos !== FALSE)
    {
        $con = open_database();
        foreach($datos as $fila){
            $ubicacion = $fila[0];
            $sku = $fila[1];
            $pasillo = $fila[2];
            $rack = $fila[3];
            $columna = $fila[4];
            $nivel = $fila[5];
            $prioridad = $fila[6];
            $sql_busqueda = "SELECT sku FROM Producto WHERE sku='".$sku."'";
            $resultado = mysqli_query($con,$sql_busqueda);
            if($resultado)
            {
                $fila = mysqli_fetch_row($resultado);
                if($fila == NULL)
                {
                    $bandera2 = false;
                    $bandera = false;
                    echo "El producto ".$sku." no esta registrado\n";
                    continue;
                }
            }
            else
            {
                $bandera = false;
                echo "Error ".mysqli_errno($con)." : ".mysqli_error($con)."\n";
            }
            $sql_busqueda = "SELECT ubicacion FROM Producto WHERE sku ='".$sku."'";
            $resultado = mysqli_query($con,$sql_busqueda);
            if($resultado)
            {
                $fila = mysqli_fetch_row($resultado);
                if($fila != NULL)
                {
                    $sql_ubicacion = "UPDATE Producto SET ubicacion='".$ubicacion."' WHERE sku='".$sku."'";
                    $resultado = mysqli_query($con,$sql_ubicacion);
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
            $sql_query = "INSERT INTO Ubicacion (ubicacion,sku,pasillo,rack,columna,nivel,prioridad) VALUES ('".$ubicacion."','".$sku."','".$pasillo."','".$rack."','".$columna."','".$nivel."','".$prioridad."')";
            $resultado = mysqli_query($con, $sql_query);
            if(!$resultado)
            {
                $bandera = false;
                echo "Error ".mysqli_errno($con)." : ".mysqli_error($con)."\n";
            }
        }
        if($bandera)
            echo "EXITO";
        if($bandera2)
            echo "FALTAN_PRODUCTOS";
        mysqli_close($con);
    }
}
else
{
    echo "ERROR_ARCHIVO";
}
?>