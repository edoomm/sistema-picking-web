
<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $nom = $_POST['modificarNombre'];

  $link = open_database();

  $sql = 'UPDATE Operador SET nombre ="'.$nom.'" WHERE num_empleado ="'.$num.'";';
  $result = $link->query($sql);

  $link->close();
?>