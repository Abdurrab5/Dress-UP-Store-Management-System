<?php
include 'connection.php';

// Fetch all orders
$sql = "SELECT `id`, `user_name`, `user_email`, `address`, `city`, `phone`, 
        `payment_method`, `cart_data`, `status`, `created_at` 
        FROM `orders` 
        ORDER BY `created_at` ASC";

$result = $conn->query($sql);
$orders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Decode cart_data JSON if stored that way
        if (!empty($row['cart_data'])) {
            $row['cart_data'] = json_decode($row['cart_data'], true);
        }
        $orders[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($orders);
?>
