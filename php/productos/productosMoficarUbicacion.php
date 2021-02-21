<?php
    include_once "../db.php";
    $numeroUbicaciones = $_POST['numeroUbicaciones'];
    $sku = $_POST["sku"];
    $ubicaciones = array();
    $conn = open_database();
    $bandera = true;
    for($i = 0; $i<$numeroUbicaciones; $i++)
    {
        $id = "ubicacion".strval($i);
        $ubicaciones[$i] = $_POST[$id];
        $sql_query = "SELECT sku FROM Ubicacion WHERE ubicacion='".$ubicaciones[$i]."'";
        $resultado = mysqli_query($conn,$sql_query);
        if(!$resultado)
        {
            echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
            $bandera = false;
        }
        $fila = mysqli_fetch_row($resultado);
        if($fila == NULL)
        {
            echo "La ubicación ".$ubicaciones[$i]." no existe\n";
            $bandera = false;
            continue;
        }
        if($fila[0] != NULL)
        {
            echo "La ubicación ".$ubicaciones[$i]." ya tiene un producto registrado\n";
            $bandera = false;
        }
    }
    if($bandera)
    {
        $bandera = true;
        for($i = 0; $i<$numeroUbicaciones; $i++)
        {
            if(strcmp($ubicaciones[$i],"SIN ASIGNAR") != 0)
            {
                if($i == 0)
                {
                    $sql_query = "UPDATE Producto SET ubicacion='".$ubicaciones[$i]."' WHERE sku='".$sku."'";
                    $resultado = mysqli_query($conn,$sql_query);
                    if(!$resultado)
                    {
                        echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
                        $bandera = false;
                    }
                }
                $id = "ubicacion".strval($i);
                $sql_query = "UPDATE Ubicacion SET sku ='".$sku."' WHERE ubicacion='".$ubicaciones[$i]."'";
                $resultado = mysqli_query($conn,$sql_query);
                if(!$resultado)
                {
                    echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
                    $bandera = false;
                }
    
            }
            else
            {
                
            }
        }
        if($bandera)
            echo "La operación se realizo con éxito";
    }
?>
