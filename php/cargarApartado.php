<?php
include 'db.php';
include 'leerCSV.php';
if(isset($_FILES['file_name'])){
    /*
        0  -> id_sucursal
        1  -> sku
        2  -> numero_control
        3  -> apartado
    */
    $datos = obtener_contenido();
    if($datos !== FALSE){
        $conn = open_database();
        foreach($datos as $fila){
            $id_sucursal = $fila[0];
            $sku = $fila[1];
            $numero_control = $fila[2];
            $apartado = $fila[3];
            $sql_query = "INSERT INTO Control (id_sucursal, apartado, sku, numero_control) VALUES ('".$id_sucursal."','".$apartado."','".$sku."','".$numero_control."')"; 
            echo $sql_query . "\n";
            if(mysqli_query($conn, $sql_query) === FALSE){
                echo "ERROR_QUERY";
            }
        }
        mysqli_close($conn);
    }
}
else{
    echo "ERROR_ARCHIVO";
}
?>