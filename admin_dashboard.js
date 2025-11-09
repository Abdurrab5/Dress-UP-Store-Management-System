document.addEventListener('DOMContentLoaded', () => {
    const sidebarItems = document.querySelectorAll('.sidebar ul li');
    const contentSections = document.querySelectorAll('.content-section');

    const addProductBtn = document.getElementById('addProductBtn');
    const productModal = document.getElementById('productModal');
    const productForm = document.getElementById('productForm');
    const productTableBody = document.getElementById('productTableBody');

    const addCategoryBtn = document.getElementById('addCategoryBtn');
    const categoryModal = document.getElementById('categoryModal');
    const categoryForm = document.getElementById('categoryForm');
    const categoryTableBody = document.getElementById('categoryTableBody');

    const totalProductsSpan = document.getElementById('total-products');

    let products = [];
    let categories = [];

    // --- Product Form Submit using FormData ---
    productForm?.addEventListener('submit', async e => {
        e.preventDefault();
        const id = document.getElementById('productId').value;

        const formData = new FormData();
        if (id) formData.append('id', id);
        formData.append('name', document.getElementById('productName').value);
        formData.append('price', parseFloat(document.getElementById('productPrice').value));
        formData.append('stock', parseInt(document.getElementById('productStock').value));
        formData.append('category_id', document.getElementById('productCategory').value);

        const fileInput = document.getElementById('productImageFile');
        if (fileInput && fileInput.files.length > 0) {
            formData.append('image', fileInput.files[0]);
        }

        const url = id ? 'update_product.php' : 'add_product.php';

        try {
            const res = await fetch(url, { method: 'POST', body: formData });
            const data = await res.json();
            if (data.success) {
                productModal.style.display = 'none';
                productForm.reset();
                fetchProducts();
            } else {
                alert(data.message || 'Error saving product');
            }
        } catch (err) {
            console.error('Product save error:', err);
            alert('Error saving product');
        }
    });

    // --- Sidebar Navigation ---
    sidebarItems.forEach(item => {
        item.addEventListener('click', () => {
            sidebarItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            const target = item.getAttribute('data-section');
            contentSections.forEach(sec => sec.classList.remove('active'));
            document.getElementById(target).classList.add('active');

            if (target === 'dashboard') fetchProducts();
            if (target === 'categories') fetchCategories();
            if (target === 'orders') fetchOrders();

        });
    });
const orderTableBody = document.getElementById('orderTableBody');
let orders = [];

// Fetch & Render Orders
async function fetchOrders() {
    try {
        const res = await fetch('get_order.php');
        orders = await res.json();
        renderOrders();
    } catch (err) {
        console.error('Fetch orders error:', err);
    }
}

function renderOrders() {
    if (!orderTableBody) return;
    orderTableBody.innerHTML = '';
    orders.forEach(order => {
        const row = orderTableBody.insertRow();
        row.innerHTML = `
            <td>${order.id}</td>
            <td>${order.user_name} (${order.user_email})</td>
            <td>${
                Array.isArray(order.cart_data) 
                ? order.cart_data.reduce((sum, item) => sum + (item.price * item.quantity), 0).toFixed(2)
                : 'N/A'
            }</td>
            <td>${order.status}</td>
            <td>
                <button class="btn view-order-btn" data-id="${order.id}">View</button>
            </td>
        `;
    });
}

    // --- Fetch & Render Products ---
    async function fetchProducts() {
        try {
            const res = await fetch('get_products.php');
            products = await res.json();
            renderProducts();
            updateDashboard();
        } catch (err) {
            console.error('Fetch products error:', err);
        }
    }

    function renderProducts() {
        if (!productTableBody) return;
        productTableBody.innerHTML = '';
        products.forEach(p => {
            const row = productTableBody.insertRow();
            row.dataset.id = p.id;
            row.innerHTML = `
                <td>${p.id}</td>
                <td><img src="${p.image}" alt="${p.name}" width="50"></td>
                <td>${p.name}</td>
                <td>$${parseFloat(p.price).toFixed(2)}</td>
                <td>${p.stock}</td>
                <td>${p.category_name || ''}</td>
                <td>
                    <button class="btn edit-btn" data-id="${p.id}">Edit</button>
                    <button class="btn delete-btn" data-id="${p.id}">Delete</button>
                </td>
            `;
        });
    }

    function updateDashboard() {
        if (totalProductsSpan) totalProductsSpan.textContent = products.length;
    }

    // --- Fetch & Render Categories ---
    async function fetchCategories() {
        try {
            const res = await fetch('get_categories.php');
            categories = await res.json();
            renderCategories();
            populateCategoryDropdown();
        } catch (err) {
            console.error('Fetch categories error:', err);
        }
    }

    function renderCategories() {
        if (!categoryTableBody) return;
        categoryTableBody.innerHTML = '';
        categories.forEach(cat => {
            const row = categoryTableBody.insertRow();
            row.dataset.id = cat.id;
            row.innerHTML = `
                <td>${cat.id}</td>
                <td>${cat.name}</td>
                <td>
                    <button class="btn edit-category-btn" data-id="${cat.id}">Edit</button>
                    <button class="btn delete-category-btn" data-id="${cat.id}">Delete</button>
                </td>
            `;
        });
    }

    function populateCategoryDropdown(selectedId = '') {
        let select = document.getElementById('productCategory');
        if (!select) {
            const div = document.createElement('div');
            div.classList.add('form-group');
            div.innerHTML = `
                <label for="productCategory">Category:</label>
                <select id="productCategory" required></select>
            `;
            productForm.insertBefore(div, productForm.querySelector('button'));
            select = document.getElementById('productCategory');
        }
        select.innerHTML = '<option value="">Select Category</option>';
        categories.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.name;
            if (selectedId == c.id) opt.selected = true;
            select.appendChild(opt);
        });
    }

    // --- Product Modal ---
    addProductBtn?.addEventListener('click', async () => {
        productForm.reset();
        document.getElementById('productId').value = '';
        await fetchCategories();
        productModal.querySelector('h2').textContent = 'Add New Product';
        productModal.style.display = 'flex';
    });

    // --- Category Modal ---
    addCategoryBtn?.addEventListener('click', () => {
        categoryForm.reset();
        document.getElementById('categoryId').value = '';
        categoryModal.style.display = 'flex';
    });
// --- Category Form Submit ---
categoryForm?.addEventListener('submit', async e => {
    e.preventDefault();

    const id = document.getElementById('categoryId').value;
    const name = document.getElementById('categoryName').value.trim();

    if (!name) {
        alert('Category name required');
        return;
    }

    const payload = { name };
    const url = id ? 'update_category.php' : 'add_category.php'; // choose URL based on edit or add
    if (id) payload.id = id; // include id if editing

    try {
        const res = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (data.success) {
            categoryModal.style.display = 'none';
            categoryForm.reset();
            fetchCategories(); // reload categories table
        } else {
            alert(data.message || 'Error saving category');
        }
    } catch (err) {
        console.error('Category save error:', err);
        alert('Error saving category');
    }
});

    // --- Close Modals ---
    document.querySelectorAll('.close-button').forEach(btn => {
        btn.addEventListener('click', () => btn.closest('.modal').style.display = 'none');
    });
    window.addEventListener('click', e => {
        if (e.target.classList.contains('modal')) e.target.style.display = 'none';
    });

    // --- Edit/Delete Product ---
    productTableBody?.addEventListener('click', async e => {
        const btn = e.target.closest('button');
        if (!btn) return;
        const id = btn.dataset.id;
        const product = products.find(p => p.id == id);
        if (btn.classList.contains('edit-btn')) {
            document.getElementById('productId').value = product.id;
            document.getElementById('productName').value = product.name;
            document.getElementById('productPrice').value = product.price;
            document.getElementById('productStock').value = product.stock;
            await fetchCategories();
            populateCategoryDropdown(product.category_id);
            productModal.querySelector('h2').textContent = 'Edit Product';
            productModal.style.display = 'flex';
        } else if (btn.classList.contains('delete-btn')) {
            if (confirm('Are you sure?')) {
                try {
                    const res = await fetch('delete_product.php', {
                        method: 'POST',
                        body: JSON.stringify({ id }),
                        headers: { 'Content-Type': 'application/json' }
                    });
                    const data = await res.json();
                    if (data.success) fetchProducts();
                    else alert('Delete failed');
                } catch (err) {
                    console.error('Delete product error:', err);
                }
            }
        }
    });

    // --- Edit/Delete Category ---
    categoryTableBody?.addEventListener('click', async e => {
        const btn = e.target.closest('button');
        if (!btn) return;
        const id = btn.dataset.id;
        const cat = categories.find(c => c.id == id);
        if (btn.classList.contains('edit-category-btn')) {
            document.getElementById('categoryId').value = cat.id;
            document.getElementById('categoryName').value = cat.name;
            categoryModal.style.display = 'flex';
        } else if (btn.classList.contains('delete-category-btn')) {
            if (confirm('Are you sure?')) {
                try {
                    const res = await fetch('delete_category.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id })
                    });
                    const data = await res.json();
                    if (data.success) fetchCategories();
                    else alert('Delete failed');
                } catch (err) {
                    console.error('Delete category error:', err);
                }
            }
        }
    });

    // --- Initial Load ---
    fetchCategories();
    fetchProducts();
});
