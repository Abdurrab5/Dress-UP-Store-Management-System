<?php
session_start();
include 'connection.php';

// Only allow POST with file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $category_id = $_POST['category_id'] ?? null;

    if (!$name || !$category_id) {
        echo json_encode(['success' => false, 'message' => 'Name and category required']);
        exit;
    }

    // Handle file upload
    $imagePath = 'images/default.png'; // default image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = time() . '_' . $_FILES['image']['name'];
        $fileName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $fileName); // sanitize
        $destPath = 'images/' . $fileName;
        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            echo json_encode(['success' => false, 'message' => 'Image upload failed']);
            exit;
        }
        $imagePath = $destPath;
    }

    $stmt = $conn->prepare("INSERT INTO products (name, price, stock, image, category_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdisi", $name, $price, $stock, $imagePath, $category_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
