// kids.js - FINAL VERSION with Add to Cart + LocalStorage

const galleryData = [
  {
    id: 101,
    imageUrl: 'girl.jpg',
    title: 'DRESS',
    description: 'Stylish summer dress with floral patterns.',
    price: 'Rs 2,499',
    category: 'Girls',
    badge: 'new'
  },
  {
    id: 102,
    imageUrl: 'coton frock.webp',
    title: 'Baby Girl Pink Chicken Fancy Cotton Frock',
    description: 'Beautiful pink chicken embroidery frock for baby',
    price: 'Rs. 2,890',
    category: 'Girls',
    badge: 'Limited Edition'
  },
  {
    id: 103,
    imageUrl: 'boy.webp',
    title: 'Embroidered Shirt',
    description: 'Boy Half sleeves Fish Embroidered Shirt',
    price: 'Rs. 1,592',
    category: 'Boys',
    badge: 'New'
  },
  {
    id: 104,
    imageUrl: 'denim pent.webp',
    title: 'Boy Dark Blue Denim pant',
    description: 'Stylish denim in dark blue.',
    price: 'Rs. 1,272',
    category: 'Boys',
    badge: 'Exclusive'
  },
  {
    id: 105,
    imageUrl: 'salwar boys1.webp',
    title: 'Dark Purple Boys Kameez Shalwar',
    description: 'Perfect for special occasions.',
    price: 'Rs 2,645',
    category: 'Boys',
    badge: 'Exclusive'
  },
  {
    id: 106,
    imageUrl: 'Pink-01.webp',
    title: 'Pink Embroidered Girls 2PC',
    description: 'Perfect for events.',
    price: 'Rs 4,590',
    category: 'Girls',
    badge: 'Exclusive'
  },
    {
    id: 107,
    imageUrl: 'baby_set.webp',
    title: 'Baby Unisex Bodysuits Fruits Print',
    description: 'Very comfortable.',
    price: 'Rs. 790',
    category: 'New Born',
    badge: 'New'
  },
  {
    id: 108,
    imageUrl: 'Babyset.webp',
    title: 'Baby Boy 3 Piece Sky Bow Print',
    description: 'Comfortable 3-piece set.',
    price: 'Rs. 1,743',
    category: 'New Born',
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
