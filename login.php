<?php
  include_once "php/db.php";
  $link = open_database();

  $usuario = $_POST['usuario'];
  $contrasena = $_POST['contrasena'];

  $validar_login = mysqli_query($link,"SELECT * FROM usuario WHERE usuario='$usuario' and contrasena='$contrasena'");

  if (mysqli_num_rows($validar_login) > 0) {
    header("location: menu/menuPrincipal.html");
    exit;
  }
  else {
    echo '
          <script>
                alert("Credenciales incorrectas, verifique su usuario o contraseña");
                window.location = "index.html";
          </script>
    ';
     exit;
  }

  $result = $link->query($validar_login);
  $link->close();

  echo $validar_login;
 ?>
