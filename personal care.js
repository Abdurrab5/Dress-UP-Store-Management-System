// Gallery data with categories
const galleryData = [
    {
        id: 1,
        imageUrl: 'acne-control-cleanser-packshot-3999-v1.webp',
        title: 'Acne Control Cleanser',
        description: 'Effective acne control cleanser',
        price: 'Rs 3,999',
        category: 'ALL',
        badge: 'new'
    },
    {
        id: 2,
        imageUrl: ' baby-moisturizing-lotion-front-4499.webp',
        title: 'Baby Moisturizing Lotion',
        description: 'Gentle moisturizing lotion for babies',
        price: 'Rs. 4,499',
        category: 'Baby',
        badge: 'Limited Edition'
    },
    {
        id: 3,
        imageUrl: 'BabyLifestyleImage2cream5lotion8wash5999-1.jpg',
        title: 'Baby Lifestyle ',
        description: 'Complete baby care set',
        price: 'Rs. 5,999',
        category: 'Baby',
        badge: 'New'
    },
    {
        id: 4,
        imageUrl: 'cerave_sa_body_wash 49991.webp',
        title: 'CeraVe SA Body Wash',
        description: 'Gentle exfoliating body wash',
        price: 'Rs. 4,991',
        category: 'ALL',
        badge: 'Exclusive'
    },
    {
        id: 5,
        imageUrl: 'cerve facial moisturizing lotion spf 30 3999.webp',
        title: 'CeraVe Facial Moisturizing Lotion SPF 30',
        description: 'Hydrating facial moisturizer with SPF 30',
        price: 'Rs. 3,999',
        category: 'ALL',
        badge: 'Exclusive'
    },
    {
        id: 6,
        imageUrl: 'CeraveWhiteningKit-7999.webp',
        title: 'Cerave Whitening Kit',
        description: 'Cerave whitening kit for skin brightening',
        price: ' Rs. 7,999',
        category: 'ALL',
        badge: 'Exclusive'
    },
    {
        id: 7,
        imageUrl: 'foaming_cleansing_bar 4999-v2.webp',
        title: 'Foaming Cleansing Bar',
        description: 'Gentle foaming cleansing bar',
        price: 'Rs. 4,999',
        category: 'ALL',
        badge: 'New'
    },
    {
        id: 8,
        imageUrl: 'skincare.webp',
        title: 'Skincare Set',
        description: 'Complete skincare set for all skin types',
        price: 'Rs. 9,999',
        category: 'ALL',
        badge: 'Bestseller'
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
