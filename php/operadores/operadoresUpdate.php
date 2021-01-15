<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $mail = $_POST['modificarCorreo'];
  $nom = $_POST['modificarNombre'];

  $link = open_database();

  $sql = 'UPDATE Operador SET nombre ="'.$nom.'", correo = "'.$mail.'" WHERE num_empleado ="'.$num.'";';
  $result = $link->query($sql);

  $link->close();
?>