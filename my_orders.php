<?php
session_start();
include 'connection.php';

// Only logged-in customers can access
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: login.html');
    exit;
}

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];
$userEmail = $_SESSION['user_email'];

// Get orders of logged-in user
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_email = ? ORDER BY id DESC");
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Orders</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fff0f6;
      padding: 30px;
    }
    h2 {
      text-align: center;
      color: #ff69b4;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 25px;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 15px;
      border-bottom: 1px solid #eee;
      text-align: center;
    }
    th {
      background-color: #ffe4ec;
      color: #e91e63;
    }
    tr:hover {
      background-color: #fff5fa;
    }
  </style>
</head>
<body>

  <h2>📦 My Orders - <?php echo htmlspecialchars($userName); ?></h2>

  <table>
    <tr>
      <th>Order ID</th>
      <th>Address</th>
      <th>City</th>
      <th>Phone</th>
      <th>Payment</th>
      <th>Status</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['address']; ?></td>
          <td><?php echo $row['city']; ?></td>
          <td><?php echo $row['phone']; ?></td>
          <td><?php echo $row['payment_method']; ?></td>
          <td><?php echo $row['status']; ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="6">No orders found.</td></tr>
    <?php endif; ?>
  </table>

</body>
</html>
