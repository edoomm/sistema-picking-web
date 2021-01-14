 <?php
  include_once "../db.php";

  $num = $_POST['inputNumeroEmpleado'];
  $nom = $_POST['inputNombre'];

  $link = open_database();

  $sql = "INSERT INTO Operador VALUES ('$num', '$nom', 1)";

  $result = $link->query($sql);
  $link->close();

?>
