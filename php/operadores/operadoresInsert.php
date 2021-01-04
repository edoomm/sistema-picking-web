<?php
  include_once "../db.php";

  $usr = $_POST['inputUsuario'];
  $pass = $_POST['inputPassword'];

  $nom = $_POST['inputNombre'];
  $num = $_POST['inputNumeroEmpleado'];
  $mail = $_POST['inputCorreo'];

  $link = open_database();

  $sql = "INSERT INTO operador VALUES ('$num', '$nom', '$mail')";

  $result = $link->query($sql);
  $link->close();

?>
