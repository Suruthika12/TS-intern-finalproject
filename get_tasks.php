<?php

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';


$user_id = $_POST['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(["status" => "error", "message" => "Missing user ID."]);
    exit;
}


$priority = $_POST['priority'] ?? '';
$status   = $_POST['status'] ?? '';
$due      = $_POST['due'] ?? '';

$query  = "SELECT * FROM tasks WHERE user_id = ?";
$params = [$user_id];
$types  = "i";

if ($priority) {
    $query .= " AND priority = ?";
    $types .= "s";
    $params[] = $priority;
}
if ($status !== '') {
    $query .= " AND is_completed = ?";
    $types .= "i";
    $params[] = $status;
}
if ($due) {
    $query .= " AND due_date = ?";
    $types .= "s";
    $params[] = $due;
}

$query .= " ORDER BY due_date ASC";


$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}


echo json_encode(["status" => "success", "tasks" => $tasks]);

$stmt->close();
$conn->close();
?>
