<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $link = open_database();

  $sql = 'SELECT * FROM operador WHERE num_empleado ="'.$num.'";';
  $result = $link->query($sql);
  $link->close();

  $data = array('$result['num_empleado']', '$result['nombre']' , '$result['correo']');
  echo $data;

?>
