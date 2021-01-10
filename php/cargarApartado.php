<?php
include 'db.php';
include 'leerCSV.php';
if(isset($_FILES['file_name'])){
    /*
        0  -> id_almacen
        1  -> sku
        2  -> id_linea
        3  -> apartado
    */
    $datos = obtener_contenido();
    $conn = open_database();
    foreach($datos as $fila){
        $id_almacen = $fila[0];
        $sku = $fila[1];
        $id_linea = $fila[2];
        $apartado = $fila[3];
        $sql_query = "";
        echo "id_almacen: " . $id_almacen . " SKU: " . $sku . " id_linea " . $id_linea . " apartado: " . $apartado . "\n";
        //$sql_query debe tener la query para insersión de datos
        //mysqli_query($conn, $sql_query);
    }
    mysqli_close($conn);
}
else{
    echo "El archivo no pudo ser cargado con éxito\n";
}
?>