<?php
include 'connection.php';
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

$sql = "UPDATE orders SET status='Confirmed' WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$success = $stmt->execute();

echo json_encode(['success' => $success]);
?>
