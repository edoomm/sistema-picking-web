<?php
  include_once "../db.php";

  $num = $_POST['numeroSerie'];
  $link = open_database();

  $sql = 'SELECT * FROM dispositivo WHERE dispositivo_id ="'.$num.'";';
  $result = $link->query($sql);
  $link->close();

  // output data of each row
  $actual = $result->fetch_assoc();
  $n = $actual["operador_num_empleado"];


  $data = array();

  $data[0] = $n;
  

  echo json_encode($data);
  exit();
?>
