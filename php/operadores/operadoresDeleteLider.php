<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $link = open_database();

  $sql = 'DELETE FROM Usuario WHERE operador_num_empleado ="'.$num.'";';
  $link->query($sql);

  $link->close();
?>
