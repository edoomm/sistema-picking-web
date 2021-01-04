
<?php
include '../php/db.php';

$conection = open_database();
$query = $_POST["insert_query"];

if(mysqli_query($conection, $query))
	echo "All done";
else
	echo "Error";

?>
