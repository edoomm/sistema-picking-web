<?php

function open_database() {
    $host = "localhost";
    $user = "gabriel";
    $pwd = "57425595";
    $db = "pickingdb";

    $conn = mysqli_connect($host, $user, $pwd, $db);
    mysqli_set_charset($conn, "utf8mb4");

    if (mysqli_connect_errno($conn))
      echo "Failed to connect to MySQL: " . mysqli_connect_error();

    return $conn;
}

?>
