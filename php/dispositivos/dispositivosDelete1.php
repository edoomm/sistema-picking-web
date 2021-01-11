<?php
  include_once "../db.php";

  $num = $_POST['numeroSerie'];
  $link = open_database();

  $sql = 'DELETE FROM dispositivo WHERE dispositivo_id ="'.$num.'";';

  $result = $link->query($sql);
  $link->close();
?>
