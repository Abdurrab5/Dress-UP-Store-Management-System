<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="admin dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li class="active" data-section="dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
        <li data-section="products"><i class="fas fa-box"></i> Products</li>
        <li data-section="categories"><i class="fas fa-tags"></i> Categories</li>
        <li data-section="orders"><i class="fas fa-shopping-cart"></i> Orders</li>
        <li ><a href="logout.php" class="btn primary-btn "><i class="fas fa-signup"></i> Logout</a></li>
    
 
   </ul>
</div>

<div class="main-content">
    <header>
        <h1>Dashboard Overview</h1>
        <div class="user-info">
            <i class="fas fa-user-circle"></i> Admin User
        </div>
    </header>

    <!-- Dashboard Section -->
    <section id="dashboard" class="content-section active">
        <h2>Dashboard Overview</h2>
        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Products</h3>
                <p id="total-products">0</p>
            </div>
            <div class="card">
                <h3>Pending orders</h3>
                <p id="pending-orders">0</p>
            </div>
            <div class="card">
                <h3>Confirm Orders</h3>
                <p id="confirm-orders">0</p>
            </div>
        </div>
     </section>

    <!-- Product Management -->
    <section id="products" class="content-section">
        <h2>Product Management</h2>
        <button id="addProductBtn" class="btn primary-btn"><i class="fas fa-plus"></i> Add New Product</button>
          <?php
 

// Fetch low stock products (less than 5)
$lowStockProducts = [];
$stmt = $conn->prepare("SELECT id, name, stock FROM products WHERE stock < 5");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $lowStockProducts[] = $row;
}
$stmt->close();
?>
<!-- Low Stock Alert -->
<?php if (!empty($lowStockProducts)): ?>
<div id="low-stock-alert" style="background-color:#ffcccc; padding:15px; border-radius:5px; margin-bottom:20px;">
    <strong>⚠ Low Stock Alert!</strong>
    <ul>
        <?php foreach ($lowStockProducts as $product): ?>
            <li>
                <?php echo htmlspecialchars($product['name']); ?> - Quantity: <?php echo $product['stock']; ?>
                <!-- Optional: Approve/Update stock button -->
                  </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productTableBody"></tbody>
            </table>
        </div>
    </section>

    <!-- Category Management -->
    <section id="categories" class="content-section">
        <h2>Category Management</h2>
        <button id="addCategoryBtn" class="btn primary-btn"><i class="fas fa-plus"></i> Add New Category</button>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="categoryTableBody"></tbody>
            </table>
        </div>
    </section>

    <!-- Order Management -->
    <section id="orders" class="content-section">
        <h2>Order Management</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody"></tbody>
            </table>
        </div>
    </section>
</div>

<!-- Product Modal -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Add/Edit Product</h2>
        <form id="productForm">
            <input type="hidden" id="productId">
            <div class="form-group">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" required>
            </div>
            <div class="form-group">
                <label for="productPrice">Price:</label>
                <input type="number" id="productPrice" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="productStock">Stock:</label>
                <input type="number" id="productStock" required>
            </div>
            <div class="form-group">
    <label for="productImage">Product Image:</label>
    <input type="file" id="productImageFile" accept="image/*">
</div>

            <!-- Category dropdown populated dynamically by JS -->
            <button type="submit" class="btn primary-btn">Save Product</button>
        </form>
    </div>
</div>

<!-- Category Modal -->
<div id="categoryModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Add/Edit Category</h2>
        <form id="categoryForm">
            <input type="hidden" id="categoryId">
            <div class="form-group">
                <label for="categoryName">Category Name:</label>
                <input type="text" id="categoryName" required>
            </div>
            <button type="submit" class="btn primary-btn">Save Category</button>
        </form>
    </div>
</div>

<script src="admin_dashboard.js"></script>
</body>
</html>
