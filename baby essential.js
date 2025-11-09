// Gallery data with categories
const galleryData = [
    {
        id: 1,
        imageUrl: 'baby reuse able nappy set 2650.webp',
        title: 'Baby Reusable Nappy Set',
        description: 'Soft and comfortable reusable nappy set for babies',
        price: 'Rs 2,650',
        category: 'ALL',
        badge: 'new'
    },
    {
        id: 2,
        imageUrl: 'baby bouncer 1400.webp',
        title: ' Baby Bouncer',
        description: 'Comfortable baby bouncer for soothing',
        price: 'Rs. 1,700',
        category: 'Baby',
        badge: 'Limited Edition'
    },
    {
        id: 3,
        imageUrl: 'baby adjustable nappy 565.webp',
        title: 'Baby Adjustable Nappy',
        description: 'Adjustable nappy for babies',
        price: 'Rs. 790',
        category: 'Baby',
        badge: 'New'
    },
    {
        id: 4,
        imageUrl: 'baby swing 26,00.webp',
        title: 'Baby Swing',
        description: 'comfortable baby swing for soothing',
        price: 'Rs. 2,600',
        category: 'Baby',
        badge: 'Exclusive'
    },
    {
        id: 5,
        imageUrl: 'baby tub 10,00.webp',
        title: 'Baby Tub',
        description: 'Baby tub for bathing',
        price: 'Rs. 9,009',
        category:'Baby' ,
        badge: 'Exclusive'
    },
    {
        id: 6,
        imageUrl: 'baby wipes 80 sheets 1110.webp',
        title: 'Baby Wipes 80 Sheets',
        description: 'Gentle baby wipes with 80 sheets',
        price: ' Rs. 1,190',
        category: 'Baby',
        badge: 'Exclusive'
    },
    {
        id: 7,
        imageUrl: 'bath tub 5200.webp',
        title: 'Bath Tub',
        description: 'Comfortable bath tub for babies',
        price: 'Rs. 5,800',
        category: 'Baby',
        badge: 'New'
    },
    {
        id: 8,
        imageUrl: 'baby wipes 467.webp',
        title: 'Baby Wipes 467 Sheets',
        description: 'Gentle baby wipes with 467 sheets',
        price: 'Rs. 1,399',
        category: 'Baby',
        badge: 'Bestseller'
    },
    {
        id: 9,
        imageUrl: 'starter baby fiding set.webp',
        title: 'Starter Baby Feeding Set',
        description: 'Complete feeding set for babies',
        price: 'Rs. 1,590',
        category: 'Baby',
        badge: 'Bestseller'
    },
    {
        id: 10,
        imageUrl: 'swaddle wrap 1550.webp',
        title: 'Swaddle Wrap',
        description: 'Soft and comfortable swaddle wrap for babies',
        price: 'Rs. 1,559',
        category: 'Baby',
        badge: 'New'
    },
    {
        id: 11,
        imageUrl: 'soft touch nipple 2550.webp',
        title: 'Soft Touch Nipple',
        description: 'Soft touch nipple for baby bottles',
        price: 'Rs. 2,550',
        category: 'Baby',
        badge: 'Limited Edition'
    },
    {
        id: 12,
        imageUrl: 'cancol baby fidder.webp',
        title: 'Cancol Baby Fider',
        description: 'Cancol baby fider for easy feeding',
        price: 'Rs. 1,300',
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
