<?php
session_start();
include 'connection.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $category_id = $_POST['category_id'] ?? null;

    if (!$id || !$name || !$category_id) {
        echo json_encode(['success' => false, 'message' => 'ID, name, and category required']);
        exit;
    }

    // Get current product to check old image
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows !== 1) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }
    $product = $result->fetch_assoc();
    $currentImage = $product['image'];

    // Handle file upload
    $imagePath = $currentImage; // keep old image by default
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = time() . '_' . $_FILES['image']['name'];
        $fileName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $fileName); // sanitize
        $destPath = 'images/' . $fileName;
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $imagePath = $destPath;
            // Delete old image if not default
            if ($currentImage && file_exists($currentImage) && $currentImage !== 'images/default.png') {
                unlink($currentImage);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Image upload failed']);
            exit;
        }
    }

    // Update product
    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, stock=?, image=?, category_id=? WHERE id=?");
    $stmt->bind_param("sdisii", $name, $price, $stock, $imagePath, $category_id, $id);

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
