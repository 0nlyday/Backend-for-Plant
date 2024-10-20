<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_name = "herb_database";
$db_user = "root";
$db_password = "";
$db_host = "localhost";
$db_port = "3306";

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name, $db_port);

if (!$conn) {
    error_log("Connection failed: " . mysqli_connect_error());
    die(json_encode(["error" => "Connection failed: " . mysqli_connect_error()]));
}

$id = isset($_GET['veget_id']) ? intval($_GET['veget_id']) : 0;

error_log("Received veget_id: " . $id);

if ($id === 0) {
    error_log("Invalid veget_id received");
    die(json_encode(["error" => "Invalid veget_id"]));
}

$sql = "SELECT * FROM vegetables WHERE veget_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    error_log("Statement preparation failed: " . $conn->error);
    die(json_encode(["error" => "Statement preparation failed"]));
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    error_log("Data found: " . json_encode($data));
    
    $response = [
        'description' => $data['description'] ?? '',
        'benefits' => $data['benefits'] ?? '',
        'recommended_dishes' => $data['recommended_dishes'] ?? '',
        'image' => ''
    ];
    
    $imageUrl = "http://192.168.20.69/backEnd/image/";
    if (isset($data['image']) && !empty($data['image'])) {
        $response['image'] = $imageUrl . $data['image'];
    }
    
    error_log("Sending response: " . json_encode($response));
    
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    error_log("No data found for veget_id: " . $id);
    echo json_encode(["error" => "No data found for this ID"]);
}

$stmt->close();
$conn->close();
?>