<?php
include 'db.php';

$task_id = $_POST['task_id'] ?? null;
$user_id = $_POST['user_id'] ?? null;

if (!$task_id || !$user_id) {
    echo json_encode(["status" => "error", "message" => "Task ID and user ID are required."]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Task deleted successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to delete task."]);
}

$stmt->close();
$conn->close();
?>
