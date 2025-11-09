<?php session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cart</title>
  <link rel="stylesheet" href="cart.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="cart-container">
    <div class="cart-header">
      <h1 class="cart-title">Your Shopping Cart</h1>
      <span id="cart-count">0 items</span>
    </div>
    <div id="cart-items" class="cart-items"></div>

    <div class="cart-summary">
      <h3 class="summary-title">Order Summary</h3>
      <div class="summary-row">
        <span>Subtotal</span>
        <span id="subtotal">Rs 0</span>
      </div>
      <div class="summary-row">
        <span>Tax</span>
        <span id="tax">Rs 0</span>
      </div>
      <div class="summary-row total-row">
        <span>Total</span>
        <span id="total">Rs 0</span>
      </div>
      <div class="cart-actions">
        <button class="btn btn-outline" onclick="window.location.href='index.php'">
          <i class="fas fa-arrow-left"></i> Continue Shopping
        </button>
       <a href="checkout.php">
  <button class="btn btn-primary">
    Proceed to Checkout <i class="fas fa-arrow-right"></i>
  </button>
</a>

      </div>
    </div>
  </div>

  
        <!-- Payment section added by JS -->
      </div>
    </div>
  </div>

  <script src="cart.js"></script>
</body>
</html>
