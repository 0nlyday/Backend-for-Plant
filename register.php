<?php
require "connect.php";

if (!$conn) {
    echo json_encode(['error' => 'Connection error']);
    exit();
}

$password = $_POST['password'] ?? '';
$Email = $_POST['email'] ?? '';

$sql = "INSERT INTO users (password, email) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

// Bind only two parameters as you have two placeholders
$stmt->bind_param("ss", $password, $Email);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Registration successful']);
} else {
    echo json_encode(['error' => 'Registration failed']);
}

$stmt->close();
$conn->close();
?>
