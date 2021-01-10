<?php
include '../php/db.php';

$conection = open_database();
$query = $_POST["query"];

$result = mysqli_query($conection, $query);
$rows = array();
while($r = mysqli_fetch_assoc($result)){
	$rows[] = $r;
}
echo json_encode($rows);

?>
