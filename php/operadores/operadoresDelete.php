<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $link = open_database();

  $sql = 'DELETE FROM operador WHERE num_empleado ="'.$num.'";';

  $result = $link->query($sql);
  $link->close();
?>
