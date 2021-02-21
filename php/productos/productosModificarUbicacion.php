<?php
    include_once "../db.php";
    $numeroUbicaciones = $_POST['numeroUbicaciones'];
    $sku = $_POST["sku"];
    $ubicaciones = array();
    $ubicacionOri = array();
    $conn = open_database();
    $bandera = true;
    for($i = 0; $i<$numeroUbicaciones; $i++)
    {
        $id = "ubicacion".strval($i);
        $idOri = "ubicacionMod".strval($i);
        $ubicaciones[$i] = $_POST[$id];
        $ubicacionesOri[$i] = $_POST[$idOri];
        if(strcmp($ubicaciones[$i],"SIN ASIGNAR") == 0)
        {
            continue;
        }
        $sql_query = "SELECT sku FROM Ubicacion WHERE ubicacion='".$ubicaciones[$i]."'";
        $resultado = mysqli_query($conn,$sql_query);
        if(!$resultado)
        {
            echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
            $bandera = false;
            continue;
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
            if($fila[0] == $sku)
            {
                continue;
            }
            else
            {
                echo "La ubicación ".$ubicaciones[$i]." ya tiene un producto registrado\n";
                $bandera = false;
            }
        }
    }
    if($bandera)
    {
        $bandera = true;
        $sql_query = "UPDATE Producto SET ubicacion= 'SIN ASIGNAR' WHERE sku='".$sku."'";
        $resultado = mysqli_query($conn,$sql_query);
        if(!$resultado)
        {
            echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
            $bandera = false;
        }
        for($i = 0; $i<$numeroUbicaciones; $i++)
        {
            $sql_query = "UPDATE Ubicacion SET sku=NULL WHERE ubicacion='".$ubicacionesOri[$i]."'";
            $resultado = mysqli_query($conn,$sql_query);
            if(!$resultado)
            {
                echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
                $bandera = false;
            }
        }
        for($i = 0; $i<$numeroUbicaciones; $i++)
        {
            if(strcmp($ubicaciones[$i],"SIN ASIGNAR") != 0)
            {
                $sql_query = "UPDATE Producto SET ubicacion='".$ubicaciones[$i]."' WHERE sku='".$sku."'";
                $resultado = mysqli_query($conn,$sql_query);
                if(!$resultado)
                {
                    echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
                    $bandera = false;
                }
                $sql_query = "UPDATE Ubicacion SET sku ='".$sku."' WHERE ubicacion='".$ubicaciones[$i]."'";
                $resultado = mysqli_query($conn,$sql_query);
                if(!$resultado)
                {
                    echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
                    $bandera = false;
                }
            }
        }
        if($bandera)
            echo "La operación se realizo con éxito";
    }
?>
