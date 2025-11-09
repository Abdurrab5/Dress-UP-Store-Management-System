// customer_dashboard.js

const toggleSidebar = document.getElementById('toggleSidebar');
const sidebar = document.getElementById('sidebar');

toggleSidebar.addEventListener('click', function () {
    sidebar.classList.toggle('show');
});

// Optional: close sidebar when clicking outside
document.addEventListener('click', function (e) {
    if (!sidebar.contains(e.target) && !toggleSidebar.contains(e.target)) {
        sidebar.classList.remove('show');
    }
});

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