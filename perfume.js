// Gallery data with categories
const galleryData = [
    {
        id: 1,
        imageUrl: 'per women 5000webp.webp',
        title: 'Dream land',
        description: 'Dream land perfume',
        price: 'Rs 2,499',
        category: 'Women',
        badge: 'new'
    },
    {
        id: 2,
        imageUrl: ' perfume 3500.webp',
        title: 'Fusion',
        description: 'Fusion perfume',
        price: 'Rs. 3,500',
        category: 'Women',
        badge: 'Limited Edition'
    },
    {
        id: 3,
        imageUrl: 'FreshDahila women 1600.webp',
        title: 'Fresh Dahila',
        description: 'Fresh Dahila perfume',
        price: 'Rs. 1,600',
        category: 'Women',
        badge: 'New'
    },
    {
        id: 4,
        imageUrl: 'GlowIntensewomen 5000.webp',
        title: 'Glow Intense',
        description: 'Glow Intense perfume',
        price: 'Rs. 5,000',
        category: 'Women',
        badge: 'Exclusive'
    },
    {
        id: 5,
        imageUrl: 'men j perfume.webp',
        title: 'j. perfume',
        description: 'j.perfume .',
        price: 'Rs. 2,500',
        category: 'Men',
        badge: 'Exclusive'
    },
    {
        id: 6,
        imageUrl: 'men spice gold  5,300.webp',
        title: ' Spice Gold',
        description: 'Spice Gold perfume.',
        price: ' Rs. 5,300',
        category: 'Men',
        badge: 'Exclusive'
    },
    {
        id: 7,
        imageUrl: 'men 5500.webp',
        title: 'TWIlight  ',
        description: 'TWI LIGHT perfume.',
        price: 'Rs. 5,500',
        category: 'Men',
        badge: 'New'
    },
    {
        id: 8,
        imageUrl: 'men3900 perfume.webp',
        title: 'ELIXIR',
        description: 'ELIXIR perfume',
        price: 'Rs. 3,900',
        category: 'Men',
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
