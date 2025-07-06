<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1); 


$conn = new mysqli("localhost", "root", "", "taskmate");
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit;
}


$task = htmlspecialchars(trim($_POST['task'] ?? ''));
$due_date = $_POST['due_date'] ?? null;
$priority = $_POST['priority'] ?? 'Medium';
$user_id = $_POST['user_id'] ?? null;


if (empty($task) || empty($user_id)) {
    echo json_encode(["status" => "error", "message" => "Missing required fields."]);
    exit;
}


if (!empty($due_date) && strtotime($due_date) < strtotime(date("Y-m-d"))) {
    echo json_encode(["status" => "error", "message" => "Due date cannot be in the past."]);
    exit;
}


$stmt = $conn->prepare("INSERT INTO tasks (user_id, task, due_date, priority) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $user_id, $task, $due_date, $priority);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Task added successfully."]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to add task.",
        "error" => $stmt->error 
    ]);
}

$stmt->close();
$conn->close();
?>
