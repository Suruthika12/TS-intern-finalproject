<?php
include 'db.php';

$task_id = $_POST['task_id'] ?? null;
$is_completed = $_POST['is_completed'] ?? null;

if (!isset($task_id) || !isset($is_completed)) {
    echo json_encode(["status" => "error", "message" => "Missing data."]);
    exit;
}

$stmt = $conn->prepare("UPDATE tasks SET is_completed = ? WHERE id = ?");
$stmt->bind_param("ii", $is_completed, $task_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Task status updated."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update status."]);
}

$stmt->close();
$conn->close();
?>
