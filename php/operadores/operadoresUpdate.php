
<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $nom = $_POST['modificarNombre'];
  $act = $_POST['actividad_usr'];

  $link = open_database();

  $sql = 'UPDATE Operador SET nombre ="'.$nom.'" WHERE num_empleado ="'.$num.'";';
  $link->query($sql);

  $sql2 = 'UPDATE Operador SET activo ="'.$act.'" WHERE num_empleado ="'.$num.'";';
  $link->query($sql2);

  $link->close();
?>
