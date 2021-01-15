<?php
  include_once "../db.php";

  $link = open_database();
  $accion = $_POST['tipo_movimiento'];

  $sql = 'SELECT num_empleado from Operador';
  $result = $link->query($sql);


  $numero = array();
  $cantidad = array();

  $i = 0;

  foreach ($result as $row){
     $num =  $row['num_empleado'];

     $numero[$i] = $num;

     $sql2 = 'SELECT * from Transaccion WHERE num_empleado = "'.$num .'" AND tipo_movimiento = "'. $accion.'";  ';
     $result2 = $link->query($sql2);
     $actual = mysqli_num_rows($result2);

     $cantidad[$i] = $actual;

     $i++;
  }

  $link->close();

  $regresar = array();

  $regresar['numero'] = $numero;
  $regresar['cantidad'] = $cantidad;

  echo json_encode($regresar);

<<<<<<< HEAD
//var_dump($data);
=======
  exit();
?>
>>>>>>> 4e75a162ec513e4f0627733356a94cb475de0ade
