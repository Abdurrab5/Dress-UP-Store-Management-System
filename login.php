<?php
 include 'header.php';
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM login WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_name']  = $user['firstname'] . ' ' . $user['lastname'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role']  = $user['role'];

            switch ($user['role']) {
                case 'admin':
                    header("Location: admin_dashboard.php");
                    break;
                case 'owner':
                    header("Location: owner_dashboard.php");
                    break;
                default:
                    header("Location: customer_dashboard.php");
                    break;
            }
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "User not found!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Login - DressUp Studio</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<link rel="stylesheet" href="login.css"/> <!-- Same CSS used for signup -->
</head>
<body>

<div class="background-image"></div>

<div class="auth-container">
    <section class="login-section">
        <div class="form-header">
            <h2>Welcome Back</h2>
            <p>Login to access your account</p>
        </div>

        <?php if (isset($error)) echo "<p style='color:red;text-align:center;'>$error</p>"; ?>

        <form method="POST">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
                <span class="password-toggle"><i class="fas fa-eye"></i></span>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>

            <div class="form-footer">
                <p>Don't have an account? <a href="signup.php">Sign up</a></p>
                <p><a href="#">Forgot password?</a></p>
            </div>
        </form>
    </section>
</div>

</body>
</html>
