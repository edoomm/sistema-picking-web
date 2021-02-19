<?php
    include_once "../db.php";
    $ubicacion = $_POST["ubicacion"];
    $conn = open_database();
    $sql_busqueda = "SELECT ubicacion FROM Ubicacion WHERE ubicacion ='".$ubicacion."'";
    $resultado = mysqli_query($conn,$sql_busqueda);
    if($resultado)
    {
        $fila = mysqli_fetch_row($resultado);
        if($fila != NULL)
        {
            $sql_query = "SELECT sku FROM Ubicacion WHERE ubicacion ='".$ubicacion."'";
            $resultado = mysqli_query($conn,$sql_query);
            if($resultado)
            {
                $fila = mysqli_fetch_row($resultado);
                if($fila != NULL)
                {
                    if($fila[0] != NULL)
                    {
                        echo $fila[0];
                    }
                    else
                    {
                        echo "SIN_ASIGNAR";
                    }
                }
                else
                {
                    echo "SIN_ASIGNAR";
                }
            }
            else
            {
                echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
            }
        }
        else
        {
            echo "NO_EXISTE";
        }
        
    }
    else
    {
        echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
    }



?>