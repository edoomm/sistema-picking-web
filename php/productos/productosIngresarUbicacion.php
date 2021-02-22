<?php
    include_once "../db.php";
    $ubicacion = $_POST['id'];
    $pasillo = $_POST['pasillo'];
    $rack = $_POST['rack'];
    $columna = $_POST['columna'];
    $nivel = $_POST['nivel'];
    $prioridad = $_POST['prioridad'];
    $conn = open_database();
    $sql_busqueda = "SELECT ubicacion FROM Ubicacion WHERE ubicacion = '".$ubicacion."'";
    $resultado = mysqli_query($conn,$sql_busqueda);
    if($resultado)
    {
        $fila = mysqli_fetch_row($resultado);
        if($fila == NULL)
        {
            $sql_query = "INSERT INTO Ubicacion VALUES('".$ubicacion."',NULL,'".$pasillo."','".$rack."','".$columna."','".$nivel."','".$prioridad."')";
            $resultado = mysqli_query($conn,$sql_query);
            if($resultado)
            {
                echo "EXITO";
            }
            else
            {
                echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
            }
        }
        else
        {
            echo "La ubicacion ".$ubicacion." ya esta registrada";
        }
    }
    else
    {
        echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
    }