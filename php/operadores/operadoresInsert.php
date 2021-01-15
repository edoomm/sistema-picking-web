 <?php
  include_once "../db.php";

  $num = $_POST['inputNumeroEmpleado'];
  $nom = $_POST['inputNombre'];

  $link = open_database();

<<<<<<< HEAD
  $sql = "INSERT INTO Operador VALUES ('$num', '$nom', '$mail')";
=======
  $sql = "INSERT INTO Operador VALUES ('$num', '$nom', 1)";
>>>>>>> 4e75a162ec513e4f0627733356a94cb475de0ade

  $result = $link->query($sql);
  $link->close();

?>