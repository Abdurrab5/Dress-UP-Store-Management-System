<?php
session_start();
include 'connection.php';

// Only allow admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);
$id = isset($data['id']) ? intval($data['id']) : 0;
$name = trim($data['name'] ?? '');

if (!$id || !$name) {
    echo json_encode(['success' => false, 'message' => 'Category ID and name are required']);
    exit;
}

$stmt = $conn->prepare("UPDATE categories SET name=? WHERE id=?");
$stmt->bind_param("si", $name, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
