<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "dressup_studio";  // ✅ Make sure this is your exact DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?>
