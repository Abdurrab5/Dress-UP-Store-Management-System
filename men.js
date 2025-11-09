// Gallery data with categories
const galleryData = [
    {
        id: 1,
        imageUrl: 'KURTA WHITE.jpg',
        title: 'KURTA WHITE',
        description: 'KURTA WHITE SUIT YOUR PERSONALITY',
        price: 'Rs 2,499',
        category: 'Estern',
        badge: 'new'
    },
    {
        id: 2,
        imageUrl: 'men suit.jpg',
        title: 'Brown Suit',
        description: 'Brown suit with  embroidery ',
        price: 'Rs. 2,890',
        category: 'Estern',
        badge: 'Limited Edition'
    },
    {
        id: 3,
        imageUrl: 'polo shirt.webp',
        title: ' Shirt',
        description: ' Boy Half sleeves  Shirt for Summer Collection',
        price: 'Rs. 1,592',
        category: 'Western',
        badge: 'New'
    },
    {
        id: 4,
        imageUrl: 'Khaki pent 1.webp',
        title: 'Khaki Pant',
        description: 'khaki pant',
        price: 'Rs. 1,272',
        category: 'Western',
        badge: 'Exclusive'
    },
    {
        id: 5,
        imageUrl: 'Cloud pent .webp',
        title: 'Cloud Pant',
        description: 'Cloud pant Perfect for special occasions.',
        price: 'Rs.954',
        category: 'Western',
        badge: 'Exclusive'
    },
    {
        id: 6,
        imageUrl: 'PISTACHIO_6.webp',
        title: ' Pistachio Shirt',
        description: 'Pistachio Shirt Perfect for special occasions.',
        price: ' Rs. 1,390',
        category: 'Western',
        badge: 'Exclusive'
    },
    {
        id: 7,
        imageUrl: 'sneaker.webp',
        title: 'Sneaker',
        description: 'Comfortable sneaker for everyday wear.',
        price: 'Rs. 5,245',
        category: 'Shoes',
        badge: 'New'
    },
    {
        id: 8,
        imageUrl: 'MenShoes.webp',
        title: 'Men Shoes',
        description: 'shoes for occasions',
        price: 'Rs. 4,000',
        category: 'Shoes',
        badge: 'Bestseller'
    }
];
    document.addEventListener('DOMContentLoaded', function () {
  const galleryContainer = document.querySelector('.gallery-container');
  const filterButtons = document.querySelectorAll('.filter-btn');
  const lightbox = document.getElementById('lightbox');
  const lightboxImage = document.getElementById('lightbox-image');
  const lightboxTitle = document.getElementById('lightbox-title');
  const lightboxDescription = document.getElementById('lightbox-description');
  const lightboxPrice = document.getElementById('lightbox-price');
  const closeLightbox = document.querySelector('.close-lightbox');
  const prevBtn = document.querySelector('.prev-btn');
  const nextBtn = document.querySelector('.next-btn');
  const zoomInBtn = document.getElementById('lightbox-zoom-in');
  const zoomOutBtn = document.getElementById('lightbox-zoom-out');
  const zoomResetBtn = document.getElementById('lightbox-zoom-reset');
  const buyBtn = document.querySelector('.buy-btn');
  const cartCount = document.querySelector('#cart-count');

  let currentIndex = 0;
  let currentScale = 1;
  let filteredItems = [...galleryData];

  function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const total = cart.reduce((sum, item) => sum + item.quantity, 0);
    if (cartCount) cartCount.textContent = total;
  }

  function renderGallery(items) {
    galleryContainer.innerHTML = '';
    items.forEach((item, index) => {
      const div = document.createElement('div');
      div.className = `gallery-item ${item.category}`;
      let badge = item.badge ? `<span class="item-badge">${item.badge}</span>` : '';
      div.innerHTML = `
        ${badge}
        <img src="${item.imageUrl}" alt="${item.title}">
        <div class="item-info">
          <h3>${item.title}</h3>
          <p>${item.description}</p>
          <span class="price">${item.price}</span>
        </div>
      `;
      div.addEventListener('click', () => openLightbox(index));
      galleryContainer.appendChild(div);
    });
  }

  function openLightbox(index) {
    currentIndex = index;
    currentScale = 1;
    lightbox.classList.add('show');
    document.body.style.overflow = 'hidden';
    updateLightboxContent();
  }

  function updateLightboxContent() {
    const item = filteredItems[currentIndex];
    lightboxImage.src = item.imageUrl;
    lightboxTitle.textContent = item.title;
    lightboxDescription.textContent = item.description;
    lightboxPrice.textContent = item.price;
  }

  function closeLightboxHandler() {
    lightbox.classList.remove('show');
    document.body.style.overflow = 'auto';
    currentScale = 1;
    lightboxImage.style.transform = `scale(${currentScale})`;
  }

  function prevItem() {
    currentIndex = (currentIndex - 1 + filteredItems.length) % filteredItems.length;
    currentScale = 1;
    updateLightboxContent();
  }

  function nextItem() {
    currentIndex = (currentIndex + 1) % filteredItems.length;
    currentScale = 1;
    updateLightboxContent();
  }

  function addToCart() {
    const item = filteredItems[currentIndex];
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existing = cart.find(i => i.id === item.id);

    if (existing) {
      existing.quantity++;
    } else {
      cart.push({
        id: item.id,
        name: item.title,
        price: item.price,
        image: item.imageUrl,
        quantity: 1
      });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    alert(`${item.title} added to cart!`);
  }

  // Filters
  filterButtons.forEach(button => {
    button.addEventListener('click', () => {
      filterButtons.forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');
      const category = button.dataset.filter;
      filteredItems = category === 'all' ? galleryData : galleryData.filter(item => item.category === category);
      renderGallery(filteredItems);
    });
  });

  closeLightbox.addEventListener('click', closeLightboxHandler);
  prevBtn.addEventListener('click', prevItem);
  nextBtn.addEventListener('click', nextItem);
  zoomInBtn.addEventListener('click', () => {
    currentScale += 0.2;
    lightboxImage.style.transform = `scale(${currentScale})`;
  });
  zoomOutBtn.addEventListener('click', () => {
    if (currentScale > 0.4) {
      currentScale -= 0.2;
      lightboxImage.style.transform = `scale(${currentScale})`;
    }
  });
  zoomResetBtn.addEventListener('click', () => {
    currentScale = 1;
    lightboxImage.style.transform = `scale(${currentScale})`;
  });

  buyBtn.addEventListener('click', addToCart);

  renderGallery(filteredItems);
  updateCartCount();
});
