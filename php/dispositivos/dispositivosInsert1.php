<?php
  include_once "../db.php";

  $num = $_POST['inputNumeroSerie'];
  $enc = $_POST['inputEncargado'];
  $tip = $_POST['inputTipo'];
  $act = $_POST['inputEstado'][0]; // solución temporal, se debe de cambiar pls

  $link = open_database();

  $sql = "INSERT INTO dispositivo VALUES ('$num', '$enc','$tip','$act')";

  $result = $link->query($sql);
  $link->close();

  echo $sql;

?>
