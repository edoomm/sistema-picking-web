<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $link = open_database();

  $sql1 = 'DELETE FROM Usuario WHERE operador_num_empleado ="'.$num.'";';
  $sql2 = 'DELETE FROM Reporte WHERE num_empleado ="'.$num.'";';
  $sql3 = 'DELETE FROM Dispositivo WHERE num_empleado ="'.$num.'";';
  $sql4 = 'DELETE FROM Operador_has_control WHERE num_empleado ="'.$num.'";';
  $sql5 = 'DELETE FROM Transaccion WHERE num_empleado ="'.$num.'";';
  $sql6 = 'DELETE FROM Control WHERE num_empleado ="'.$num.'";';
  $sql7 = 'DELETE FROM Operador WHERE num_empleado ="'.$num.'";';

  $link->query($sql1);
  $link->query($sql2);
  $link->query($sql3);
  $link->query($sql4);
  $link->query($sql5);
  $link->query($sql6);
  $link->query($sql7);

  $link->close();
?>
