<?php
  include_once "../db.php";

  $num = $_POST['numero_empleado'];
  $usr = $_POST['lider2Usuario'];
  $pass = $_POST['lider2Password'];

  $link = open_database();

  $sql = 'INSERT INTO Usuario Values ("'.$num. '" , "'.$usr. '" ,"'.$pass. '", 1); ';
  $result = $link->query($sql);

  
  $link->close();

?>
