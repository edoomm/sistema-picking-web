<?php
include_once '../db.php';
$conn = open_database();
$sql_query = "SELECT num_empleado,nombre  FROM Operador";
if(($res=mysqli_query($conn,$sql_query))!==FALSE){
    while($fila=mysqli_fetch_row($res)){
        $num_operador = $fila[0];
        $nombre = $fila[1];
        echo "<input class=\"form-check-input\" type=\"checkbox\" name=\"operadores\" id=\"".$num_operador."\" value=\"".$num_operador."\">\n";
        echo "<label class=\"form-check.label\" for=\"".$num_operador."\">".$num_operador." ".$nombre . "</label><br>\n";
    }
}
?>