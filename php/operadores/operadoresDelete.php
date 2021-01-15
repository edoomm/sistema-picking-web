<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $link = open_database();

  $sql2 = 'DELETE FROM Usuario WHERE operador_num_empleado ="'.$num.'";';
  $sql1 = 'DELETE FROM Operador WHERE num_empleado ="'.$num.'";';

  $link->query($sql2);
  $link->query($sql1);

  $link->close();
?>