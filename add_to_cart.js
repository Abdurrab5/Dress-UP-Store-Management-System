document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-to-cart-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const productId = this.dataset.productId;

            // Prevent duplicate requests
            if (this.classList.contains('loading')) return;
            this.classList.add('loading');
            this.textContent = 'Adding...';

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + encodeURIComponent(productId)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update cart badge
                    document.querySelector('#cart-count').textContent = data.cartCount;
                    this.textContent = 'Added!';
                } else {
                    alert(data.message || 'Failed to add item.');
                    this.textContent = 'Add to Cart';
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Something went wrong.');
                this.textContent = 'Add to Cart';
            })
            .finally(() => {
                this.classList.remove('loading');
            });
        });
    });
});
