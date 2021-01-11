<?php
include 'db.php';
$table_name = $_POST['variable'];
$conn = open_database();
$sql_query = "SELECT * FROM " . $table_name;
// echo $sql_query;
if(($result = mysqli_query($conn, $sql_query))!== FALSE){
    while($fila = mysqli_fetch_row($result)){
        echo "<tr>\n";
        foreach($fila as $celda){
            echo "<td>" . $celda . "</td>\n";
        }
        echo "</tr>\n";
    }
    mysqli_free_result($result);
}
mysqli_close($conn);
?>