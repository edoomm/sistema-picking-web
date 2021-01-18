<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Insert master user</title>
    <meta name='viewport'
        content='width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no' />
    <meta name="description" content="">
    <meta name="keywords" content="">
</head>

<body>

    <?php

    include '../../../php/db.php';
    $link = open_database();
    
    $response = "";

    // verifying if it already exists

    $query_master_user = "SELECT * FROM Usuario WHERE operador_num_empleado = '-0'";
    $result_master_user = mysqli_query($link, $query_master_user);
    if (mysqli_num_rows($result_master_user) == 1) {
        $response = "Usuario master ya existe";
    }

    // verifies if just exists in table Operador
    $query_master_operator = "SELECT * FROM Operador WHERE num_empleado = '-0'";
    $result_master_operator = mysqli_query($link, $query_master_operator);
    if (mysqli_num_rows($result_master_operator) == 1) {
        $insert_master_user = "INSERT INTO Usuario (operador_num_empleado, contrasena, tipo_usuario) VALUE ('-0', '" . md5("5619849863") . "', -1)";
        if (mysqli_query($link, $insert_master_user)) {
            $response = "Usuario master creado con éxito";
        }
        else {
            $response = "El usuario master no pudo ser creado, inténtelo más tarde";
        }
    }


    $insert_master_operator = "INSERT INTO Operador (num_empleado, nombre) VALUE ('-0', 'admin')";
    if (mysqli_query($link, $insert_master_operator)) {
        $response = "Operador master creado con éxito";
    }
    else {
        $response = "El Operador master no pudo ser creado, inténtelo más tarde";
    }
    $insert_master_user = "INSERT INTO Usuario (operador_num_empleado, contrasena, tipo_usuario) VALUE ('-0', '" . md5("5619849863") . "', -1)";
    if (mysqli_query($link, $insert_master_user))
        $response = "Usuario master creado con éxito";
    else
        $response = "El usuario master no pudo ser creado, inténtelo más tarde";

    mysqli_close($link);
    
    ?>

</body>

</html>
<script>
    window.onload = function() {
        // redirecting to login
        window.location.replace("../../../");
    }
</script>