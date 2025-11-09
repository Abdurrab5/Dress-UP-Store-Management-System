<?php
// product_details.php
include 'connection.php';
include 'header.php';

$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$productId) {
    echo "Invalid product.";
    exit;
}

$stmt = $conn->prepare("SELECT name, price, stock, image, category_id FROM products WHERE id=?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$stmt->bind_result($name, $price, $stock, $image, $category_id);
if (!$stmt->fetch()) {
    echo "Product not found.";
    exit;
}
$stmt->close();
?>
<style>
body {
    font-family: 'Arial', sans-serif;
    background: #f5f5f5;
    margin: 0;
    padding: 0;
}

.p-container {
    max-width: 1200px;
    margin: 120px auto;
    background: #fff;
    display: flex;
    flex-wrap: wrap;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.product-image {
    flex: 1.1;
    min-width: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f9f9f9;
    padding: 30px;
}

.product-image img {
    width: 100%;
    max-height: 600px;
    object-fit: contain;
    border-radius: 12px;
    cursor: zoom-in;
    transition: transform 0.3s ease;
}

.product-image img.zoomed {
    transform: scale(2);
    cursor: zoom-out;
}

.product-details {
    flex: 0.9;
    min-width: 350px;
    padding: 40px 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.product-details h1 {
    margin: 0 0 20px 0;
    font-size: 32px;
    color: #333;
}

.product-details .price {
    font-size: 28px;
    color: #e65c50;
    font-weight: bold;
    margin-bottom: 15px;
}

.product-details .stock {
    font-size: 16px;
    color: #fff;
    background: <?php echo $stock>5 ? '#28a745' : '#dc3545'; ?>;
    display: inline-block;
    padding: 5px 12px;
    border-radius: 6px;
    margin-bottom: 20px;
}

.product-details .description {
    font-size: 16px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 25px;
}

.product-details button {
    background: #ff6f61;
    color: #fff;
    border: none;
    padding: 15px 25px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.product-details button:hover {
    background: #e65c50;
}

@media(max-width: 992px){
    .p-container {
        flex-direction: column;
        margin: 40px 20px;
    }
    .product-image, .product-details {
        min-width: 100%;
        padding: 20px;
    }
    .product-details h1 {
        font-size: 26px;
    }
    .product-details .price {
        font-size: 24px;
    }
}
</style>
<div class="p-container">
    <div class="product-image">
        <img id="product-img" src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($name); ?>">
    </div>
    <div class="product-details">
        <h1><?php echo htmlspecialchars($name); ?></h1>
        <p class="price">$<?php echo number_format($price, 2); ?></p>
        <span class="stock">Stock: <?php echo $stock; ?></span>
        <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id fermentum turpis, vel luctus odio. Sed lacinia semper ex, at vehicula est gravida sit amet.</p>
        
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'customer'): ?>
            <button class="add-to-cart-btn" data-id="<?php echo $productId; ?>">
                <i class="fas fa-cart-plus"></i> Add to Cart
            </button>
        <?php endif; ?>
    </div>
</div>

<script>
const img = document.getElementById('product-img');
img.addEventListener('click', () => {
    img.classList.toggle('zoomed');
});

// Add to cart functionality only if button exists
const addToCartBtn = document.querySelector('.add-to-cart-btn');
if (addToCartBtn) {
    addToCartBtn.addEventListener('click', async function() {
        const productId = this.dataset.id;
        try {
            const res = await fetch('add_to_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ product_id: productId })
            });
            const data = await res.json();
            if (data.success) {
                alert('Product added to cart!');
            } else {
                alert(data.message || 'Failed to add product');
            }
        } catch (err) {
            console.error(err);
            alert('Error adding product to cart');
        }
    });
}
</script>
