<?php
include 'connection.php'; // database connection

$password = password_hash('Admin@123', PASSWORD_DEFAULT);

$sql = "INSERT INTO login(firstname, email, password, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $email, $password, $role);

$username = 'admin';
$email = 'admin@gmail.com';
$role = 'admin';

$stmt->execute();
echo "Admin inserted successfully!";
?>
