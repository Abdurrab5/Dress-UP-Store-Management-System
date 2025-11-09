<?php
// allproducts.php
include 'connection.php';
 include 'header.php';
 
$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Fetch category name
$categoryName = '';
if ($categoryId) {
    $stmt = $conn->prepare("SELECT name FROM categories WHERE id=?");
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $stmt->bind_result($categoryName);
    $stmt->fetch();
    $stmt->close();
}

// Fetch products in this category
$products = [];
if ($categoryId) {
    $stmt = $conn->prepare("SELECT id, name, price, stock, image FROM products WHERE category_id=? AND stock>0");
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $stmt->close();
}
?> 
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
}
.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 0 15px;
}
h1 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
}
.product-grid {
  
    display: grid;
    grid-template-columns: repeat(auto-fill,minmax(250px,1fr));
    gap: 20px;
}
.product-card {
      margin-top:50px;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}
.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
.product-card .details {
    padding: 15px;
    text-align: center;
}
.product-card .details h3 {
    font-size: 18px;
    margin: 10px 0;
    color: #333;
}
.product-card .details p {
    font-size: 16px;
    color: #666;
}
.product-card .details button {
    background: #ff6f61;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
}
.product-card .details button:hover {
    background: #e65c50;
}
</style>
</head>
<body>
 
<div class="container">
    <h1>Products: <?php echo htmlspecialchars($categoryName ?: "All"); ?></h1>
    <?php if (empty($products)): ?>
        <p style="text-align:center; color:#555;">No products available in this category.</p>
    <?php else: ?>
    <div class="product-grid">
        <?php foreach ($products as $p): ?>
            <div class="product-card">
                <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
                <div class="details">
    <h3><?php echo htmlspecialchars($p['name']); ?></h3>
    <p>$<?php echo number_format($p['price'], 2); ?></p>
    
    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'customer'): ?>
        <button class="add-to-cart-btn" data-id="<?php echo $p['id']; ?>">
            <i class="fas fa-cart-plus"></i> Add to Cart
        </button>
    <?php endif; ?>

    <a href="product_details.php?id=<?php echo $p['id']; ?>" style="display:block; margin-top:10px;">
        View Details
    </a>
</div>

            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Function to update cart count
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

    // Attach click event to add-to-cart buttons
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

    // Initial cart count load
    updateCartCount();
});
</script>


</body>
</html>
