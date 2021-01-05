<?php

function open_database() {
    $host = "localhost";
    $user = "root";
<<<<<<< HEAD
    $pwd = "1234";
=======
    $pwd = "";
>>>>>>> 65c4804d2a7205a0ed70ef8ad54e95fc03823c50
    $db = "pickingdb";

    $conn = mysqli_connect($host, $user, $pwd, $db);
    mysqli_set_charset($conn, "utf8mb4");

    if (mysqli_connect_errno($conn))
      echo "Failed to connect to MySQL: " . mysqli_connect_error();

    return $conn;
}

?>
