<?php
session_start();
include 'connection.php';

$customerId = $_SESSION['user_id'] ?? 0;

if (!$customerId) {
    echo json_encode(['count' => 0]);
    exit;
}

// Fetch total quantity of items in cart
$stmt = $conn->prepare("SELECT SUM(quantity) as total FROM cartitem WHERE customer_id=?");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

echo json_encode(['count' => $total ?? 0]);
?>
