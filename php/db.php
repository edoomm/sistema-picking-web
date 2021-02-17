<?php

function open_database() {
    $host = "localhost";
    $user = "root";
    $pwd = "";
    $db = "pickingdb";

    $conn = mysqli_connect($host, $user, $pwd, $db);
    mysqli_set_charset($conn, "utf8mb4");

  
    return $conn;
}

?>
