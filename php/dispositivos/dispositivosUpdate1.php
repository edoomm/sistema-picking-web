<?php
  include_once "../db.php";

  $num = $_POST['numeroSerie'];
  $enc = $_POST['modificarEncargado'];
  $est = $_POST['modificarEstado'];

  $link = open_database();

  $sql = 'UPDATE dispositivo SET operador_num_empleado ="'.$enc.'", activo = "'.$est.'" WHERE dispositivo_id ="'.$num.'";';
  $result = $link->query($sql);
  $link->close();
?>
