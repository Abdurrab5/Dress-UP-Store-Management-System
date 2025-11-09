<?php
session_start();
include 'connection.php';
 
include 'header.php';
$customerId = $_SESSION['user_id'] ?? 0;
 
if (!$customerId) {
    header("Location: login.php");
    exit;
}

// Fetch cart items with product info
$stmt = $conn->prepare("
    SELECT 
        c.id as cart_id, 
        p.id as product_id, 
        p.name, 
        p.price, 
        p.image, 
        c.quantity
    FROM cartitem c
    JOIN products p ON c.product_id = p.id
    WHERE c.customer_id = ?
");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();

 
$cartItems = [];
$totalAmount = 0;

while ($row = $result->fetch_assoc()) {
    $row['total'] = $row['price'] * $row['quantity'];
    $totalAmount += $row['total'];
    $cartItems[] = $row;
}

$stmt->close();
$conn->close();
?>
 <style>
body { font-family: Arial, sans-serif; background: #f9f9f9; margin:0; padding:0; }
.container { max-width: 1000px; margin: 25px auto; padding: 0 15px; }
h1 { text-align:center; color:#333; margin-bottom: 30px; }
.cart-table { width:100%; border-collapse: collapse;margin-top:50px; background: #fff; border-radius: 10px; overflow:hidden; }
.cart-table th, .cart-table td { padding: 15px; text-align:center; border-bottom:1px solid #ddd; }
.cart-table th { background:#ff6f61; color:#fff; }
.cart-table img { width:80px; height:80px; object-fit:cover; border-radius:5px; }
.remove-btn { background:#e65c50; color:#fff; border:none; padding:5px 10px; border-radius:5px; cursor:pointer; }
.remove-btn:hover { background:#c94c3b; }
.total-row td { font-weight:bold; font-size:18px; }
.checkout-btn { margin-top:20px; display:block; background:#28a745; color:#fff; padding:12px 20px; border:none; border-radius:5px; text-align:center; text-decoration:none; cursor:pointer; width:100%; }
.checkout-btn:hover { background:#218838; }
</style>
 
<div class="container">
    <h1>My Cart</h1>
    
    <?php if(empty($cartItems)): ?>
        <p style="text-align:center; color:#555;">Your cart is empty.</p>
    <?php else: ?>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($cartItems as $item): ?>
            <tr id="cart-row-<?php echo $item['cart_id']; ?>">
                <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td>$<?php echo number_format($item['price'],2); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>$<?php echo number_format($item['total'],2); ?></td>
                <td>
                    <button class="remove-btn" data-id="<?php echo $item['cart_id']; ?>">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="4">Total Amount</td>
                <td colspan="2">$<?php echo number_format($totalAmount,2); ?></td>
            </tr>
        </tbody>
    </table>
    <a  href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const cartId = btn.dataset.id;
            if(!confirm('Remove this item from cart?')) return;
            try {
                const res = await fetch('remove_from_cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ cart_id: cartId })
                });
                const data = await res.json();
                if(data.success){
                    document.getElementById('cart-row-' + cartId).remove();
                    alert('Item removed from cart!');
                    location.reload(); // optional: refresh to update total
                } else {
                    alert(data.message || 'Failed to remove item');
                }
            } catch(err){
                console.error(err);
                alert('Error removing item');
            }
        });
    });
});
</script>

</body>
</html>
