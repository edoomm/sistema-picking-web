<?php
  include_once "../db.php";

  $num = $_POST['inputNumeroSerie'];
  $enc = $_POST['inputEncargado'];
  $tip = $_POST['inputTipo'];


  $link = open_database();

  $sql = "INSERT INTO dispositivo VALUES ('$num', '$enc','$tip','')";

  $result = $link->query($sql);
  $link->close();

?>
