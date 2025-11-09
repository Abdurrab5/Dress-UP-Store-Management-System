<?php
session_start();
include 'connection.php';

// Check if logged in and role is customer
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header("Location: login.html");
    exit;
}

// Get user ID
$userId = $_SESSION['user_id'];

// Fetch user details from DB
$sql = "SELECT firstname, lastname, email, phone, address FROM login WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - Customer</title>
    <link rel="stylesheet" href="customer_profile.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f2f2;
        }

        .profile-container {
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #e40b89;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }

        input[readonly] {
            background-color: #f8f8f8;
        }

        .btn {
            background-color: #e40b89;
            color: #fff;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #c91288;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>My Profile</h2>

    <!-- Success Message -->
   <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
        ✅ Profile updated successfully!
    </div>
<?php endif; ?>

    <form action="update_profile.php" method="POST">
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="firstName" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
        </div>

        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="lastName" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
        </div>

        <div class="form-group">
            <label>Phone Number:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
        </div>

        <div class="form-group">
            <label>Address:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>">
        </div>

        <button type="submit" class="btn">Update Profile</button>
    </form>
</div>

</body>
</html>
