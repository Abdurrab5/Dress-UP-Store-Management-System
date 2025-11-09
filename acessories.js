// Gallery data with categories
const galleryData = [
    {
        id: 1,
        imageUrl: 'brownglasses.webp',
        title: 'Brown Glasses',
        description: 'stylish brown glasses',
        price: 'Rs 999',
        category: 'Women',
        badge: 'new'
    },
    {
        id: 2,
        imageUrl: 'brownbelt890.webp',
        title: 'Brown Belt',
        description: 'Stylish brown belt',
        price: 'Rs. 890',
        category: 'Men',
        badge: 'Limited Edition'
    },
    {
        id: 3,
        imageUrl: 'cap 1790crop_center .webp',
        title: 'Black crop cap',
        description: 'Black crop cap',
        price: 'Rs. 1,790',
        category: 'Men',
        badge: 'New'
    },
    {
        id: 4,
        imageUrl: 'belt 1500.webp',
        title: 'BELT',
        description: 'Stylish belt',
        price: 'Rs. 1,500',
        category: 'Men',
        badge: 'Exclusive'
    },
    {
        id: 5,
        imageUrl: 'grey black cap 1790.webp',
        title: 'Grey Black Cap',
        description: 'Grey black cap',
        price: 'Rs. 1,790',
        category: 'Men',
        badge: 'Exclusive'
    },
    {
        id: 6,
        imageUrl: 'paxton stainless steel 10749.webp',
        title: 'Paxton Stainless Steel',
        description: 'Paxton stainless steel watch',
        price: ' Rs. 10,749',
        category: 'Men',
        badge: 'Exclusive'
    },
    {
        id: 7,
        imageUrl: 'prestige smartwatch 17000.webp',
        title: 'Prestige Smartwatch',
        description: 'Prestige smartwatch with advanced features',
        price: 'Rs. 17,000',
        category: 'Men',
        badge: 'New'
    },
    {
        id: 8,
        imageUrl: 'maxfit smartwatch blue 6999.webp',
        title: 'Maxfit Smartwatch Blue',
        description: 'Maxfit smartwatch in blue color',
        price: 'Rs. 6,999',
        category: 'Men',
        badge: 'Bestseller'
    },
    {
        id: 9,
        imageUrl: 'ClassicToteBag 3699_1.webp',
        title: 'Classic Tote Bag',
        description: 'Classic tote bag for everyday use',
        price: 'Rs. 3,699',
        category: 'Women',
        badge: 'Bestseller'
    },
    {
        id: 10,
        imageUrl: 'peach scarf 559.webp',
        title: 'Peach Scarf',
        description: 'Soft peach scarf ',
        price: 'Rs. 559',
        category: 'Women',
        badge: 'New'
    },
    {
        id: 11,
        imageUrl: 'Two-toneClutch_1 2899.webp',
        title: 'Two-tone Clutch',
        description: 'Elegant two-tone clutch',
        price: 'Rs. 2,899',
        category: 'Women',
        badge: 'Limited Edition'
    },
    {
        id: 12,
        imageUrl: 'siliver women watch.webp',
        title: 'watch',
        description: 'Elegant silver watch ',
        price: 'Rs. 1,599',
        category: 'Women',
        badge: 'Bestseller'
    },
    {
        id: 13,
        imageUrl: 'blue-ClassicWallet. 1299webp.webp',
        title: 'Classic Wallet',
        description: 'Blue classic wallet',
        price: 'Rs. 1,299',
        category: 'Women',
        badge: 'Exclusive'
    },
    {
        id: 14,
        imageUrl: 'golden design 3999.webp',
        title: 'watch',
        description: 'Elegant golden watch',
        price: 'Rs. 3,999',
        category: 'Women',
        badge: 'New'
    },
    
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
