<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $link = open_database();

<<<<<<< HEAD
  $sql = 'DELETE FROM Operador WHERE num_empleado ="'.$num.'";';
=======
  $sql2 = 'DELETE FROM Usuario WHERE operador_num_empleado ="'.$num.'";';
  $sql1 = 'DELETE FROM Operador WHERE num_empleado ="'.$num.'";';

  $link->query($sql2);
  $link->query($sql1);
>>>>>>> 4e75a162ec513e4f0627733356a94cb475de0ade

  $link->close();
?>