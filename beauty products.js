// Gallery data with categories
const galleryData = [
    {
        id: 1,
        imageUrl: 'eye shadow palatte cosmic 2400.webp',
        title: 'Cosmic Eye Shadow Palette',
        description: 'Vibrant cosmic eye shadow palette',
        price: 'Rs 2,400',
        category: 'Women',
        badge: 'new'
    },
    {
        id: 2,
        imageUrl: ' fit me matte foundation 115 ivory 2700.webp',
        title: ' Fit Me Matte Foundation',
        description: 'Fit Me Matte Foundation in 115 Ivory',
        price: 'Rs. 2,700',
        category: 'women',
        badge: 'Limited Edition'
    },
    {
        id: 3,
        imageUrl: 'eyeconic eyeshadow palatte.webp',
        title: 'Eyeconic Eyeshadow Palette',
        description: 'Eyeconic eyeshadow palette with rich pigments',
        price: 'Rs. 1,790',
        category: 'women',
        badge: 'New'
    },
    {
        id: 4,
        imageUrl: 'LAMELAllinOneLipTintedPlumpingOil_1500.webp',
        title: 'LAME All-in-One Lip Tinted Plumping Oil',
        description: 'All-in-One Lip Tinted Plumping Oil',
        price: 'Rs. 1,500',
        category: 'women',
        badge: 'Exclusive'
    },
    {
        id: 5,
        imageUrl: 'LAMEL16ShadesofBrown2609.webp',
        title: 'lamel 16 Shades of Brown',
        description: 'Lamel 16 Shades of Brown Lipstick',
        price: 'Rs. 2,609',
        category:'Women' ,
        badge: 'Exclusive'
    },
    {
        id: 6,
        imageUrl: 'LAMELBBBlush16190.webp',
        title: 'Lamel BB Blush',
        description: 'Lamel BB Blush ',
        price: ' Rs. 1,690',
        category: 'Women',
        badge: 'Exclusive'
    },
    {
        id: 7,
        imageUrl: 'Matte-Velvet-Waterproof-Nude-Lipstick-set-1800.webp',
        title: 'Matte Velvet Waterproof Nude Lipstick Set',
        description: 'Matte Velvet Waterproof Nude Lipstick Set',
        price: 'Rs. 1,800',
        category: 'Women',
        badge: 'New'
    },
    {
        id: 8,
        imageUrl: 'maybelline new york colossal express mascara 1399.webp',
        title: 'Colossal Express Mascara',
        description: 'Maybelline New York Colossal Express Mascara',
        price: 'Rs. 1,399',
        category: 'Women',
        badge: 'Bestseller'
    },
    {
        id: 9,
        imageUrl: 'maybelline newyork color sensational ultimatte matte lipstick 15900-21.webp',
        title: 'Color Sensational Ultimatte Matte Lipstick',
        description: 'Maybelline New York Color Sensational Ultimatte Matte Lipstick',
        price: 'Rs. 1,590',
        category: 'Women',
        badge: 'Bestseller'
    },
    {
        id: 10,
        imageUrl: 'SuperStayInkCrayonLipstick2600.webp',
        title: 'Super Stay Ink Crayon Lipstick',
        description: 'Long-lasting Super Stay Ink Crayon Lipstick',
        price: 'Rs. 2,559',
        category: 'Women',
        badge: 'New'
    },
    {
        id: 11,
        imageUrl: '-Fit-Me-Compact-Powder-Shades 2399.webp',
        title: 'Fit Me Compact Powder',
        description: 'Fit Me Compact Powder in various shades',
        price: 'Rs. 2,399',
        category: 'Women',
        badge: 'Limited Edition'
    },
    {
        id: 12,
        imageUrl: 'matte-bomb-nude-magnet2300_1.webp',
        title: 'Matte Bomb Nude Magnet',
        description: ' Matte Bomb Nude Magnet Lipstick',
        price: 'Rs. 2,300',
        category: 'Women',
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
