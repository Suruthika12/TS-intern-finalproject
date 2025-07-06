<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('db.php');

header('Content-Type: application/json');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Basic validation
if (empty($username) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Username and password required."]);
    exit;
}

// Check if user already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "Username already exists."]);
    exit;
}
$stmt->close();

// Insert new user
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "User created successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
}
$stmt->close();
$conn->close();
?>
