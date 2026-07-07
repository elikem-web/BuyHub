<?php
// ─────────────────────────────────────────────
//  BuyHub — Products API
//  backend/products.php
//  Returns vendors with their products as JSON
// ─────────────────────────────────────────────
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require_once 'db.php';

$action = $_GET['action'] ?? 'by_vendor';

// ── ALL vendors with their products ──────────
if ($action === 'by_vendor') {
    $cat = $_GET['category'] ?? '';

    // Get vendors (filtered by category if provided)
    if ($cat && $cat !== 'all') {
        $stmt = $conn->prepare("SELECT * FROM vendors WHERE category = ? ORDER BY id");
        $stmt->bind_param('s', $cat);
    } else {
        $stmt = $conn->prepare("SELECT * FROM vendors ORDER BY id");
    }
    $stmt->execute();
    $vendors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Get products for each vendor
    foreach ($vendors as &$v) {
        $stmt = $conn->prepare("
            SELECT id, name, description, price, old_price, image, badge, stock
            FROM products
            WHERE vendor_id = ? AND stock > 0
            ORDER BY id
        ");
        $stmt->bind_param('i', $v['id']);
        $stmt->execute();
        $v['products'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }

    echo json_encode(['success' => true, 'vendors' => $vendors]);
    exit;
}

// ── Single product with vendor info ──────────
if ($action === 'single') {
    $id = intval($_GET['id'] ?? 0);
    $stmt = $conn->prepare("
        SELECT p.*, v.name AS vendor_name, v.phone AS vendor_phone,
               v.email AS vendor_email, v.whatsapp AS vendor_whatsapp,
               v.location AS vendor_location
        FROM products p
        JOIN vendors v ON p.vendor_id = v.id
        WHERE p.id = ?
    ");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Product not found.']);
        exit;
    }
    echo json_encode(['success' => true, 'product' => $product]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Unknown action.']);
$conn->close();
?>
