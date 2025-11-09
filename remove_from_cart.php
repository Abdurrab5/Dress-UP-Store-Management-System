<?php
session_start();
include 'connection.php';

$customerId = $_SESSION['user_id'] ?? 0;
if (!$customerId) {
    echo json_encode(['success' => false, 'message' => 'Login required']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$cartId = intval($input['cart_id'] ?? 0);

if (!$cartId) {
    echo json_encode(['success' => false, 'message' => 'Invalid cart item']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM cartitem WHERE id=? AND customer_id=?");
$stmt->bind_param("ii", $cartId, $customerId);
$success = $stmt->execute();
$stmt->close();
$conn->close();

echo json_encode(['success' => $success]);
?>
