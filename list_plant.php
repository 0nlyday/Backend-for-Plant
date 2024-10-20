<?php
$db_name = "herb_database";
$db_user = "root";
$db_password = "";
$db_host = "localhost";
$db_port = "3306";

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name, $db_port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = $conn->query("SELECT veget_id, veget_name FROM vegetables");

$list = array();
if ($result) {
    while($row = mysqli_fetch_assoc($result)){
        $list[] = $row;
    }
    echo json_encode($list);
} else {
    echo json_encode(["error" => "Query failed"]);
}

// Close the connection
$conn->close();
?>