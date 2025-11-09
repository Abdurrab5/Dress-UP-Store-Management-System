<?php
 
include 'header.php';

$customerId = $_SESSION['user_id'] ?? 0;

if (!$customerId) {
    header("Location: login.php");
    exit;
}

// Fetch cart items
$stmt = $conn->prepare("
    SELECT c.product_id, c.quantity, p.name, p.price, (p.price * c.quantity) as total_amount
    FROM cartitem c
    JOIN products p ON c.product_id = p.id
    WHERE c.customer_id = ?
");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$cartResult = $stmt->get_result();

$cartItems = [];
$totalAmount = 0;

while ($row = $cartResult->fetch_assoc()) {
    $totalAmount += $row['total_amount'];
    $cartItems[] = $row;
}
$stmt->close();

if (empty($cartItems)) {
    echo "<p style='text-align:center;color:red;'>Your cart is empty.</p>";
    exit;
}

// Handle order placement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address        = trim($_POST['address']);
    $city           = trim($_POST['city']);
    $phone          = trim($_POST['phone']);
    $payment_method = trim($_POST['payment_method']);

    $userStmt = $conn->prepare("SELECT firstname, lastname, email FROM login WHERE id = ?");
    $userStmt->bind_param("i", $customerId);
    $userStmt->execute();
    $userData = $userStmt->get_result()->fetch_assoc();
    $userStmt->close();

    $user_name  = $userData['firstname'] . ' ' . $userData['lastname'];
    $user_email = $userData['email'];

    $cart_json = json_encode($cartItems);

    $orderStmt = $conn->prepare("
        INSERT INTO orders (user_name, user_email, address, city, phone, payment_method, cart_data, status, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())
    ");
    $orderStmt->bind_param("sssssss", $user_name, $user_email, $address, $city, $phone, $payment_method, $cart_json);

    if ($orderStmt->execute()) {
        $clearStmt = $conn->prepare("DELETE FROM cartitem WHERE customer_id = ?");
        $clearStmt->bind_param("i", $customerId);
        $clearStmt->execute();
        $clearStmt->close();

        echo "<p style='text-align:center;color:green;'>Order placed successfully! Your order ID is " . $orderStmt->insert_id . ".</p>";
    } else {
        echo "<p style='text-align:center;color:red;'>Error placing order. Please try again.</p>";
    }
    $orderStmt->close();
    $conn->close();
    exit;
}

$conn->close();
?>

<style>
:root {
  --primary: #ff69b4;
  --dark: #292f36;
  --light: #f7f7f7;
  --white: #ffffff;
  --gray: #888;
  --shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

body {
  background: var(--light);
  font-family: 'Segoe UI', sans-serif;
  padding: 40px;
}

.checkout-modal-box {
  background: var(--white);
  max-width: 1000px;
  margin: auto;
  border-radius: 15px;
  box-shadow: var(--shadow);
  padding: 25px 30px;
}

.checkout-modal-box h3 {
  text-align: center;
  color: var(--primary);
  margin-bottom: 20px;
}

.checkout-two-columns {
  display: flex;
  gap: 30px;
  flex-wrap: wrap;
}

.payment-column {
  background-color: #fff0f6;
  border: 1px solid #ff69b4;
  padding: 30px;
  border-radius: 10px;
  flex: 1.2;
}

.customer-column {
  flex: 1;
}

.form-group {
  margin-bottom: 15px;
}

.form-label {
  display: block;
  font-weight: 600;
  margin-bottom: 6px;
  color: var(--primary);
}

.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid var(--primary);
  border-radius: 8px;
  background: #fff0f6;
}

.payment-options {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.payment-btn {
  display: block;
  padding: 12px;
  border: 2px solid var(--primary);
  border-radius: 8px;
  background: #fff;
  cursor: pointer;
  font-weight: 600;
  transition: all 0.3s ease;
}

.payment-btn:hover {
  background: #ffe0ef;
}

.place-order-btn {
  width: 100%;
  padding: 14px;
  background: var(--primary);
  color: var(--white);
  border: none;
  border-radius: 10px;
  font-weight: bold;
  margin-top: 20px;
}

.summary {
  background: var(--light);
  padding: 15px;
  border-radius: 8px;
  margin-top: 20px;
}
</style>

<div class="checkout-modal-box">
  <h3>Checkout</h3>
  <form method="POST">
    <div class="checkout-two-columns">
      
      <!-- Left Column: Payment & Customer Info -->
      <div class="payment-column">
        <div class="form-group">
          <label class="form-label">Address</label>
          <input type="text" name="address" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="form-label">City</label>
          <input type="text" name="city" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="form-label">Phone</label>
          <input type="text" name="phone" class="form-control" required>
        </div>
        
        <div class="form-group">
          <label class="form-label">Payment Method</label>
          <div class="payment-options">
            <label class="payment-btn">
              <input type="radio" name="payment_method" value="Cash on Delivery" required> Cash on Delivery
            </label>
            <label class="payment-btn">
              <input type="radio" name="payment_method" value="Credit Card"> Credit Card
            </label>
          </div>
        </div>

        <button type="submit" class="place-order-btn">Place Order</button>
      </div>

      <!-- Right Column: Order Summary -->
      <div class="customer-column">
        <h4 class="section-title">Order Summary</h4>
        <div class="summary">
          <?php foreach($cartItems as $item): ?>
            <p><?php echo htmlspecialchars($item['name']); ?> (x<?php echo $item['quantity']; ?>) - $<?php echo number_format($item['total_amount'], 2); ?></p>
          <?php endforeach; ?>
          <hr>
          <p><strong>Total: $<?php echo number_format($totalAmount, 2); ?></strong></p>
        </div>
      </div>

    </div>
  </form>
</div>
