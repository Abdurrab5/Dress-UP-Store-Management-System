<?php
session_start();
include 'connection.php';

// Check if user is logged in and role is 'customer'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: login.html');
    exit;
}

// Store the user's name to use in HTML
$userName = $_SESSION['user_name'];
$userEmail = $_SESSION['user_email'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="customer_dashoboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #ff69b4, #ffe4e1);
            margin: 0;
            padding: 0;
        }

        .dashboard {
            max-width: 600px;
            margin: 80px auto;
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .dashboard h1 {
            font-size: 28px;
            color: #e40b89;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #e40b89;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #ca119c;
        }
    </style>
</head>
<body>
   <header class="dashboard-header">
    <div class="logo" id="toggleSidebar">
        👤 <?php echo htmlspecialchars($userName); ?>
    </div>
    <nav class="navbar">
        <!-- optional: top navbar if you want -->
         
              <a href="cart.php" class="fas fa-shopping-cart"></a>
             <span id="cart-count" class="cart-count">0</span>
    </nav>
</header>

<!-- 🔹 Sidebar -->
<div id="sidebar" class="sidebar">
    <ul>
        <li><a href="index.php">🏠 Home</a></li>
        <li><a href="my_orders.php">📦 My Orders</a></li>
       <li><a href="customer_profile.php">👤 My Profile</a></li>
     <li><a href="logout.php">🚪 Logout</a></li>
    </ul>
</div>


    <div class="dashboard">
        <h1>Welcome, <?php echo htmlspecialchars($userName); ?>!</h1>
        <p><strong>You have successfully logged In </strong>.</p>
        <a href="logout.php" class="btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
<script src="customer_dashboard.js" > 

  </script>
</body>
</html>
