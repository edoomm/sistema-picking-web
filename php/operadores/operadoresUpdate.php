<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $nom = $_POST['modificarNombre'];

  $link = open_database();

<<<<<<< HEAD
  $sql = 'UPDATE Operador SET nombre ="'.$nom.'", correo = "'.$mail.'" WHERE num_empleado ="'.$num.'";';
=======
  $sql = 'UPDATE Operador SET nombre ="'.$nom.'" WHERE num_empleado ="'.$num.'";';
>>>>>>> 4e75a162ec513e4f0627733356a94cb475de0ade
  $result = $link->query($sql);

  $link->close();
?>