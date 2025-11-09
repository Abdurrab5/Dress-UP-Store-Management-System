<?php
session_start();
include 'connection.php';
 

$sql = "SELECT `id`, `name`, `price`, `stock`, `image`, `category_id` FROM `products`";
$result = $conn->query($sql);
 
 
?> 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DressUp Studio- Your Online Shopping Destination</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
      <style>
     
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f6f9;
        color: #333;
    }

    header {
        background: #fff;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        position: sticky;
        top: 0;
        z-index: 999;
    }

    header h1 {
        font-size: 1.8rem;
        font-weight: bold;
        color: #ff4b2b;
    }

    nav ul {
        list-style: none;
        display: flex;
        gap: 20px;
    }

    nav a {
        text-decoration: none;
        color: #444;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    nav a:hover {
        color: #ff4b2b;
    }

    .header-icons {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 1.2rem;
        position: relative;
    }

    .cart-count {
        background: #ff4b2b;
        color: #fff;
        padding: 2px 7px;
        font-size: 0.8rem;
        border-radius: 50%;
        position: absolute;
        top: -8px;
        right: -8px;
    }

    /* Product Section */
    .container {
        width: 90%;
        max-width: 1200px;
        margin: auto;
        padding: 40px 0;
    }

    h2 {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 40px;
        color: #333;
    }

    .row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
    }

    .product-card {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .product-image-container {
        background: #fff;
        height: 250px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .product-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.15);
    }

    .card-body {
        padding: 20px;
        text-align: center;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .product-price {
        font-size: 1.3rem;
        color: #28a745;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .out-of-stock {
        font-size: 0.9rem;
        color: red;
        font-weight: bold;
    }

    .btn {
        padding: 10px 18px;
        background: #ff4b2b;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        transition: background 0.3s ease;
    }

    .btn:hover {
        background: #ff6a4d;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        nav ul {
            display: none;
        }
        .mobile-menu {
            display: block;
        }
    }
</style>

    
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
<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold">Our Products</h2>
    <div class="row g-4">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card product-card h-100">
                        <div class="product-image-container">
                            <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="product-image">
                        </div>
                       <div class="card-body text-center">
    <div class="product-name"><?php echo htmlspecialchars($row['name']); ?></div>
    <div class="product-price">$<?php echo number_format($row['price'], 2); ?></div>

    <?php if ($row['stock'] > 0): ?>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'customer'): ?>
            <button class="btn btn-primary mt-3 add-to-cart" data-id="<?php echo $row['id']; ?>">Add to Cart</button>
        <?php endif; ?>
    <?php else: ?>
        <div class="out-of-stock mt-3">Out of Stock</div>
    <?php endif; ?>
</div>

                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No products found.</p>
        <?php endif; ?>
    </div>
</div>

 
<script>
$(document).ready(function(){
    $(".add-to-cart").click(function(){
        let productId = $(this).data("id");
        $.post("add_to_cart.php", { product_id: productId }, function(response){
            alert(response.message);
        }, "json");
    });
});
</script>

</body>
</html>
