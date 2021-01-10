<?php
include 'db.php';
include 'leerCSV.php';
if(isset($_FILES['file_name'])){
    /*
        0  -> id_control
        1  -> id_sucursal
        2  -> sku
        3  -> id_linea
        4  -> apartado
    */
    $datos = obtener_contenido();
    $conn = open_database();
    foreach($datos as $fila){
        $id_sucursal = $fila[1];
        $sku = $fila[2];
        $id_linea = $fila[3];
        $apartado = $fila[4];
        //$sql_query debe tener la query para insersión de datos
        $sql_query = "INSERT INTO Control (id_sucursal, apartado, sku, asignado, numero_control) VALUES ('".$id_sucursal."','".$apartado."','".$sku."',FALSE, '1')"; 
        if(mysqli_query($conn, $sql_query) === FALSE){
            echo "No se pudo completar la transacción\n";
        }
    }
    mysqli_close($conn);
}
else{
    echo "El archivo no pudo ser cargado con éxito\n";
}
?>