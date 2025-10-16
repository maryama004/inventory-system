<?php
session_start();
include("config.php");

// ✅ Only allow logged-in admin
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// ✅ Check if ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Invalid product ID.");
}

$product_id = intval($_GET['id']);

// ✅ Prepare & execute the delete query
$stmt = $mysql_db->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    // Optional success message via session
    $_SESSION['message'] = "✅ Product deleted successfully.";
} else {
    $_SESSION['message'] = "❌ Error deleting product: " . $stmt->error;
}

$stmt->close();
$mysql_db->close();

// ✅ Redirect back to admin dashboard
header("Location: admin_db.php");
exit();
?>
