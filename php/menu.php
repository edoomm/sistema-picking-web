<?php

include 'db.php';
$link = open_database();

$respax = [];

$query = "SELECT * FROM Control WHERE estado = 0";
$result = mysqli_query($link, $query);
$respax["pendientes"] = mysqli_num_rows($result);

$query = "SELECT * FROM Control WHERE estado = 1";
$result = mysqli_query($link, $query);
$respax["enprogres"] = mysqli_num_rows($result);

$query = "SELECT * FROM Control WHERE estado = 2";
$result = mysqli_query($link, $query);
$respax["terminados"] = mysqli_num_rows($result);

mysqli_close($link);

echo json_encode($respax);

?>