<?php
session_start();
include 'connection.php';// Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['full_name'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $phone = $_POST['phone'];
  $payment = $_POST['payment_method'];
  $cart_data = $_POST['cart_data']; // JSON string

  $stmt = $conn->prepare("INSERT INTO orders (user_name, user_email, address, city, phone, payment_method, cart_data) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssssss", $name, $email, $address, $city, $phone, $payment, $cart_data);

  if ($stmt->execute()) {
    echo "<script>
      localStorage.removeItem('cart');
      window.location.href = 'thankyou.php';
    </script>";
    exit;
  } else {
    echo "Error: " . $stmt->error;
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Checkout</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="checkout.css">
</head>
<body>

  <div class="checkout-modal-box">
    <span class="close-button" onclick="window.location.href='cart.php'">&times;</span>
    <h3>Checkout</h3>

    <form id="checkout-form" method="POST">
      <div class="checkout-two-columns">

        <!-- LEFT: Customer Info -->
        <div class="customer-column">
          <h4 class="section-title">Customer Info</h4>
          <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" value="<?php echo $_SESSION['user_name'] ?? ''; ?>" readonly>
          </div>

          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $_SESSION['user_email'] ?? ''; ?>" readonly>
          </div>

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
            <input type="tel" name="phone" class="form-control" required>
          </div>
        </div>

        <!-- RIGHT: Payment Section -->
        <div class="payment-column">
          <h4 class="section-title">Payment Method</h4>
        <div class="form-group payment-options">
  <label class="payment-btn">
    <input type="radio" name="payment_method" value="COD" checked onclick="showPaymentInfo('')">
    <span>Cash on Delivery</span>
  </label>

  <label class="payment-btn">
    <input type="radio" name="payment_method" value="JazzCash" onclick="showPaymentInfo('JazzCash')">
    <span>JazzCash</span>
  </label>

  <label class="payment-btn">
    <input type="radio" name="payment_method" value="EasyPaisa" onclick="showPaymentInfo('EasyPaisa')">
    <span>EasyPaisa</span>
  </label>

  <div id="payment-instructions" style="margin-top:10px; display:none; color:#ff69b4; font-weight:bold;"></div>
</div>


          <div id="payment-instructions" style="display:none; margin-top:10px; color:var(--primary); font-weight:bold;"></div>
        </div>

      </div>

      <input type="hidden" name="cart_data" id="cart_data">
      <button type="submit" class="place-order-btn">
        <i class="fas fa-shopping-bag"></i> Place Order
      </button>
    </form>
  </div>

  <script src="checkout.js"></script>
  
</body>
</html>
