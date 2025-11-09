<?php
session_start();
include 'connection.php';

$sql = "SELECT id, name FROM categories ORDER BY name";
$result = $conn->query($sql);

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

echo json_encode($categories);
$conn->close();
?>
