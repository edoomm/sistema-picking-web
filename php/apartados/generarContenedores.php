<?php
    include_once "../db.php";
    $numeroContenedores = $_POST['num'];
    $conn = open_database();
    $sql_query = "SELECT MAX(contenedor_id) from Contenedor";
    $resultado = mysqli_query($conn,$sql_query);
    $bandera =  true;
    if($resultado)
    {
        $fila = mysqli_fetch_row($resultado);
        for($i=1;$i<=$numeroContenedores;$i++)
        {
            $sql_query = "INSERT INTO Contenedor values()";
            $resultado = mysqli_query($conn,$sql_query);
            if(!$resultado)
            {
                echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
                $bandera = false;
                break;
            }
        }
        if($bandera)
        {
            echo $fila[0]+1;
        }
    }
    else
    {
        echo "Error ".mysqli_errno($conn)." : ".mysqli_error($conn)."\n";
    }
    mysqli_close($conn);
?>