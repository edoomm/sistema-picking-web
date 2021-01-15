<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $link = open_database();

  $sql = 'SELECT * FROM  Usuario WHERE operador_num_empleado ="'.$num.'";';
  $result = $link->query($sql);

  $sql2 = 'SELECT * FROM  Usuario;';
  $result2 = $link->query($sql2);

  $link->close();

  $cantidad = mysqli_num_rows($result);
  $cantidad2 = mysqli_num_rows($result2);

  $data = array();

  $data[0] = $cantidad;
  $data[1] = $cantidad2;

  if ($data[0] != $data[1]){
    $data[1] += 10;
  }

  echo json_encode($data);
  exit();

?>