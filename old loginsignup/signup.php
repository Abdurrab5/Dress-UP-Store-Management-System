<?php
session_start(); // Start session

include 'connection.php';

// Get and sanitize form inputs
$firstName        = trim($_POST['firstName'] ?? '');
$lastName         = trim($_POST['lastName'] ?? '');
$email            = trim($_POST['email'] ?? '');
$password         = $_POST['password'] ?? '';
$confirmPassword  = $_POST['confirmPassword'] ?? '';
$role             = $_POST['role'] ?? 'customer'; // default role
$phone            = trim($_POST['phone'] ?? '');
$address          = trim($_POST['address'] ?? '');

// Validate required fields
if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
    die("Please fill all required fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

if ($password !== $confirmPassword) {
    die("Passwords do not match.");
}

// Check if email already exists
$checkSql = "SELECT id FROM login WHERE email = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    die("Email already registered. Please log in.");
}
$checkStmt->close();

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$sql = "INSERT INTO login (firstname, lastname, email, password, role, phone, address) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $firstName, $lastName, $email, $hashedPassword, $role, $phone, $address);

if ($stmt->execute()) {
    $user_id = $stmt->insert_id;

    // Set session variables
    $_SESSION['user_id']    = $user_id;
    $_SESSION['user_name']  = $firstName;
    $_SESSION['user_role']  = $role;
    $_SESSION['user_email'] = $email;

    // Redirect based on role
    switch ($role) {
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
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
