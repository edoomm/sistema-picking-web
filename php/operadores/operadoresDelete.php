<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $link = open_database();

  $sql = 'DELETE FROM Operador WHERE num_empleado ="'.$num.'";';

  $result = $link->query($sql);
  $link->close();
?>
