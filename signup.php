<?php
include 'header.php';
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $firstName = trim($_POST['firstName']);
    $lastName  = trim($_POST['lastName']);
    $email     = trim($_POST['email']);
    $phone     = trim($_POST['phone']);
    $address   = trim($_POST['address']);
    $role      = $_POST['role'] ?? 'customer';
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM login WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Email already registered. Please log in.";
    } else {
        $stmt = $conn->prepare("INSERT INTO login (firstname, lastname, email, password, role, phone, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $firstName, $lastName, $email, $password, $role, $phone, $address);

        if ($stmt->execute()) {
            $success = "Registration successful! <a href='login.php'>Login here</a>";
        } else {
            $error = "Error: " . $conn->error;
        }
        $stmt->close();
    }
    $check->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up - DressUp Studio</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<link rel="stylesheet" href="login.css"/> <!-- This will use your shared CSS -->
</head>
<body>

<div class="background-image"></div>

<div class="auth-container show-signup">
    <section class="signup-section">
        <div class="form-header">
            <h2>Create Account</h2>
            <p>Join us today and start shopping</p>
        </div>

        <?php if (!empty($error)) echo "<p style='color:red;text-align:center;'>$error</p>"; ?>
        <?php if (!empty($success)) echo "<p style='color:green;text-align:center;'>$success</p>"; ?>

        <form method="POST" class="register-form">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="firstName" placeholder="First Name" required>
            </div>
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="lastName" placeholder="Last Name" required>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="text" name="phone" placeholder="Phone Number" required>
            </div>
            <div class="input-group">
                <i class="fas fa-map-marker-alt"></i>
                <input type="text" name="address" placeholder="Address" required>
            </div>
            <div class="input-group">
                <i class="fas fa-user-shield"></i>
                <select name="role" required>
                    <option value="customer">Customer</option>
                    <option value="owner">Owner</option>
                    <option value="admin">Admin</option>
                </select>
                <span class="select-arrow"><i class="fas fa-chevron-down"></i></span>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
                <span class="password-toggle"><i class="fas fa-eye"></i></span>
            </div>

            <button type="submit" class="btn">Sign Up</button>

            <div class="form-footer">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </form>
    </section>
</div>

</body>
</html>
