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
            $sql_ubicacion = "UPDATE Producto SET ubicacion='".$ubicacion."' WHERE sku='".$sku."'";
            echo $sql_ubicacion;
            mysqli_query($con,$sql_ubicacion);
            $sql_query = "INSERT INTO Ubicacion (ubicacion,sku,pasillo,rack,columna,nivel,prioridad) VALUES ('".$ubicacion."','".$sku."','".$pasillo."','".$rack."','".$columna."','".$nivel."','".$prioridad."')";
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