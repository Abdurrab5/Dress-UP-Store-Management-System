document.addEventListener('DOMContentLoaded', function () {
  const products = [
    {
      id: 1,
      name: 'Silver Grey Elegant Dress',
      price: 2499,
      image: 'dress.webp',
      rating: 4,
      badge: 'Sale'
    },
    {
      id: 2,
      name: 'Baby Feeder',
      price: 890,
      image: 'fider.webp',
      rating: 5,
      badge: 'Hot'
    },
    {
      id: 3,
      name: 'Bluetooth Headphones',
      price: 999,
      image: 'bluthoth.webp',
      rating: 3,
      badge: ''
    }
    // Add your more products here
  ];

  const productGrid = document.querySelector('.product-grid');
  // const cartCount = document.querySelector('.cart-count'); // Removed duplicate declaration
  let cart = JSON.parse(localStorage.getItem('cart')) || [];

 const cartCount = document.querySelector('.cart-count');

function updateCartCount() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const total = cart.reduce((sum, item) => sum + item.quantity, 0);
  if (cartCount) cartCount.textContent = total;
}

function saveCart() {
  localStorage.setItem('cart', JSON.stringify(cart));
  updateCartCount();
}


  function displayProducts() {
    productGrid.innerHTML = '';
    products.forEach(product => {
      const card = document.createElement('div');
      card.className = 'product-card';
      let ratingStars = '';
      for (let i = 1; i <= 5; i++) {
        ratingStars += i <= product.rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
      }

      card.innerHTML = `
        ${product.badge ? `<span class="product-badge">${product.badge}</span>` : ''}
        <div class="product-image"><img src="${product.image}" alt="${product.name}"></div>
        <div class="product-info">
          <h3>${product.name}</h3>
          <div class="product-price"><span class="current-price">Rs ${product.price}</span></div>
          <div class="product-rating">${ratingStars}</div>
          <button class="add-to-cart" data-id="${product.id}">Add to Cart</button>
        </div>
      `;
      productGrid.appendChild(card);
    });
  }

  productGrid.addEventListener('click', function (e) {
    if (e.target.classList.contains('add-to-cart')) {
      const id = parseInt(e.target.getAttribute('data-id'));
      const product = products.find(p => p.id === id);
      const existing = cart.find(item => item.id === id);

      if (existing) {
        existing.quantity++;
      } else {
        cart.push({
          id: product.id,
          name: product.name,
          price: `Rs ${product.price}`,
          image: product.image, // ✅ YOUR image path
          quantity: 1
        });
      }

      saveCart();
    }
  });

  displayProducts();
  updateCartCount();
});
