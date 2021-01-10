 <?php
  include_once "../db.php";

  $num = $_POST['inputNumeroEmpleado'];
  $nom = $_POST['inputNombre'];
  $mail = $_POST['inputCorreo'];

  $link = open_database();

  $sql = "INSERT INTO Operador VALUES ('$num', '$nom', '$mail')";

  $result = $link->query($sql);
  $link->close();

?>
