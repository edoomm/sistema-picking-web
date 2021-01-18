<?php
include_once 'db.php';
include_once 'leerCSV.php';
if(isset($_FILES['file_name'])){
    /*
        0  -> id_sucursal
        1  -> sku
        2  -> numero_control
        3  -> apartado
    */
    $datos = obtener_contenido();
    $necesitado = array();
    if($datos !== FALSE){
        $conn = open_database();
        foreach($datos as $fila){
            $sku = $fila[1];
            $apartado = $fila[3];
            $necesitado[$sku] += $apartado;
            $sql_query = "SELECT * FROM Producto WHERE sku=".$sku;
            if(($res = mysqli_query($conn, $sql_query)) !== FALSE){
                if(!mysqli_num_rows($res)){
                    // El SKU del producto no está en la base de datos
                }
            }
        }
        foreach($necesitado as $clave => $valor){
            $sql_query = "SELECT stock FROM Producto WHERE sku=" . $clave;
            if(($res = mysqli_query($conn,$sql_query)) !== FALSE){
                $fila = mysqli_fetch_row($res);
                $stock = $fila[0];
                if($valor > $stock){
                    // Se necesita más de ese producto
                }
            }
            else{
                echo "ERROR_QUERY";
            }
        }
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