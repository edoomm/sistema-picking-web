<?php
include_once '../db.php';
include_once '../leerCSV.php';
if(isset($_FILES['file_name'])){
    /*
        0  -> id_sucursal
        1  -> sku
        2  -> numero_control
        3  -> apartado
    */
    $mensajes = array();
    $mensajes['error_sku_no_existe'] = array();
    $mensajes['stock'] = array();
    $datos = obtener_contenido();
    $necesitado = array();
    if($datos !== FALSE){
        $conn = open_database();
        foreach($datos as $fila){
            $sql_query = "SELECT * FROM Producto WHERE sku=".$fila[1];
            if(($res = mysqli_query($conn, $sql_query)) !== FALSE){
                if(!mysqli_num_rows($res)){
                    // El SKU del producto no está en la base de datos
                    array_push($mensajes['error_sku_no_existe'], $fila[1]);
                }
                else{
                    $sku = $fila[1];
                    $apartado = $fila[3];
                    $necesitado[$sku] += $apartado;
                }
            }
            else{
                array_push($mensajes['error'], "Error " . mysqli_errno($conn) . " : " . mysqli_error($conn));
            }
        }
        foreach($necesitado as $clave => $valor){
            $sql_query = "SELECT stock FROM Producto WHERE sku=" . $clave;
            if(($res = mysqli_query($conn,$sql_query)) !== FALSE){
                $fila = mysqli_fetch_row($res);
                $stock = $fila[0];
                if($valor > $stock){
                    array_push($mensajes['stock'], array($sku, $valor - $stock));
                }
            }
            else{
                array_push($mensajes['error'], "Error " . mysqli_errno($conn) . " : " . mysqli_error($conn));
            }
        }
        foreach($datos as $fila){
            $id_sucursal = $fila[0];
            $sku = $fila[1];
            $numero_control = $fila[2];
            $apartado = $fila[3];
            $sql_query = "INSERT INTO Control (id_sucursal, apartado, sku, numero_control, fecha) VALUES ('".$id_sucursal."','".$apartado."','".$sku."','".$numero_control."', CURDATE())"; 
            if(mysqli_query($conn, $sql_query) === FALSE){
                array_push($mensajes['error'], "Error " . mysqli_errno($conn) . " : " . mysqli_error($conn));
            }
        }
        mysqli_close($conn);
    }
}
else{
    array_push($mensajes['error'], "Error al copiar el archivo");
}
echo json_encode($mensajes);
?>