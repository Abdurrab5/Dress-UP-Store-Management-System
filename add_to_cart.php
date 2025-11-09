<?php
session_start();
include 'connection.php';

$customerId = $_SESSION['user_id'] ?? 0;
if (!$customerId) {
    echo json_encode(['success' => false, 'message' => 'Please log in first.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$productId = intval($input['product_id'] ?? 0);
if (!$productId) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

// Get product price
$stmtProd = $conn->prepare("SELECT price FROM products WHERE id=?");
$stmtProd->bind_param("i", $productId);
$stmtProd->execute();
$stmtProd->bind_result($price);
if (!$stmtProd->fetch()) {
    $stmtProd->close();
    echo json_encode(['success' => false, 'message' => 'Product not found']);
    exit;
}
$stmtProd->close();

// Check if product already in cart
$stmt = $conn->prepare("SELECT id, quantity FROM cartitem WHERE customer_id=? AND product_id=?");
$stmt->bind_param("ii", $customerId, $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $newQty = $row['quantity'] + 1;
    $totalAmount = $newQty * $price;
    $update = $conn->prepare("UPDATE cartitem SET quantity=?, total_amount=? WHERE id=?");
    $update->bind_param("idi", $newQty, $totalAmount, $row['id']);
    $update->execute();
    $update->close();
} else {
    $insert = $conn->prepare("INSERT INTO cartitem (customer_id, product_id, quantity, total_amount) VALUES (?, ?, 1, ?)");
    $insert->bind_param("iid", $customerId, $productId, $price);
    $insert->execute();
    $insert->close();
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true]);
