<?php
include_once('./db.php');
$conn = open_database();
$query = $_POST['query'];
$res = mysqli_query($conn,$query);
$rows = mysqli_fetch_all($res);
echo json_encode($rows);
?>