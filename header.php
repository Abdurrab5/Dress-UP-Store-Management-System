<?php
session_start();
include 'connection.php';
  
 
?> 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DressUp Studio- Your Online Shopping Destination</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1>DressUp Studio</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#sale">Sale</a></li>
                    <li><a href="#testimonials">Testimonials</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                  
                </ul>
            </nav>
            <div class="header-icons">
                
                <a href="search page.html" class="fas fa-search"></a>
                <?php
if(isset($_SESSION['user_name'])){
    $alpha = strtoupper(substr($_SESSION['user_name'], 0, 1));
    echo "<div class='user-alpha' onclick=\"window.location.href='customer_dashboard.php'\">$alpha</div>";
} else {
    echo "<a href='signup.php' class='fas fa-user'></a>";
}
?>

        

        
              <a href="cart.php" class="fas fa-shopping-cart"></a>
             <span id="cart-count" class="cart-count">0</span>

            </div>
    
            </div>
            <div class="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

   
<script>
async function updateCartCount() {
    try {
        const res = await fetch('get_cart_count.php');
        const data = await res.json();
        const cartCount = document.getElementById('cart-count');
        if (cartCount) {
            cartCount.textContent = data.count || 0;
        }
    } catch (err) {
        console.error('Error fetching cart count:', err);
    }
}

// Call on page load
document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();

    // Update cart count when adding product
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const productId = btn.dataset.id;
            try {
                const res = await fetch('add_to_cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ product_id: productId })
                });
                const data = await res.json();
                if (data.success) {
                    alert('Product added to cart!');
                    updateCartCount(); // refresh count after adding
                } else {
                    alert(data.message || 'Failed to add product');
                }
            } catch (err) {
                console.error(err);
                alert('Error adding product to cart');
            }
        });
    });
});
</script>