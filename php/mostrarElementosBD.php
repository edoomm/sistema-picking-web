<?php
include 'db.php';
$table_name = $_POST['variable'];
$conn = open_database();
$columnas = $_POST['columnas'];
$condicion = $_POST['condicion'];
$sql_query = "SELECT " . $columnas . " FROM " . $table_name . " WHERE " . $condicion;
if(($result = mysqli_query($conn, $sql_query))!== FALSE){
    while($fila = mysqli_fetch_row($result)){
        echo "<tr>\n";
        foreach($fila as $elemento){
            echo "<td>" . $elemento . "</td>";
        }
        echo "</tr>\n";
    }
    mysqli_free_result($result);
}
mysqli_close($conn);
?>