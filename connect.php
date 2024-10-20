<?php
$db_name = "user_db";
$db_user = "root";
$db_password = "";
$db_host = "localhost";
$db_port = "3306";

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name, $db_port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>