<?php
  include_once "../db.php";
  header('Content-Type: application/json');

  $link = open_database();

  $sql1 = 'SELECT num_empleado FROM operador';
  $sql2 = 'SELECT nombre FROM operador';

  $r1 = $link->query($sql1);
  $r2 = $link->query($sql2);

  $data = array();

  $r3 = [];

  foreach ($link->query($sql1) as $row){
    $sqlTMP = 'SELECT * FROM transaccion WHERE num_empleado ="'.$row['num_empleado'].'";';
    $ansTMP = $link->query($sqlTMP);
    $cantidad = mysqli_num_rows($ansTMP);
    array_push($r3,$cantidad);
  }

  array_push($r3, $r1, $r2);

  $link->close();
  $r1->close();
  $r2->close();

// Mostramos los datos en formato JSON
print json_encode($data);

//var_dump($data);