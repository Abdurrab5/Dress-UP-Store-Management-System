<?php
session_start();
include 'connection.php';

// Get form values
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Query user by email
$sql = "SELECT * FROM login WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['firstname'];
        $_SESSION['user_email'] = $user['email'];

        $_SESSION['user_role'] = $user['role'];

        // Redirect based on role
        switch ($user['role']) {
            case 'admin':
                header("Location: admin_dashboard.php");
                break;
            case 'owner':
                header("Location: owner_dashboard.php");
                break;
            case 'customer':
            default:
                header("Location: customer_dashboard.php");
                break;
        }
        exit;
    } else {
        echo "<script>alert('❌ Incorrect password'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('❌ No account found with this email'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
