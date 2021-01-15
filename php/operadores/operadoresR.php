<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $link = open_database();

  $sql = 'SELECT * FROM Operador WHERE num_empleado ="'.$num.'";';
  $result = $link->query($sql);
  $link->close();
  $cantidad = mysqli_num_rows($result);

  echo $cantidad;

?>