<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "Biology2";
$dbName = "wardrobe";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>