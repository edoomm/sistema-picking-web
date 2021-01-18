<?php
  include_once "../db.php";

  $num = $_POST['numeroSerie'];
  $link = open_database();

  $sql = 'SELECT * FROM dispositivo WHERE dispositivo_id ="'.$num.'";';
  $result = $link->query($sql);
  $link->close();
  $cantidad = mysqli_num_rows($result);

  $regresar = false;

  /*
    Igual aca no entiendo porque cantidad == 0, si se supone deberia ser cantidad==1 ¿no?
  */
  if ($cantidad == 0){
    $regresar = true;
  }

  echo $regresar;

?>
