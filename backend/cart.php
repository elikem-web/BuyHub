<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

$action  = $_POST['action'] ?? $_GET['action'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;

function needLogin() {
    echo json_encode(['success'=>false,'message'=>'Please log in to manage your cart.','redirect'=>'../login.php']);
    exit;
}

// ── FETCH with vendor contact info ────────────
if ($action === 'fetch') {
    if (!$user_id) { echo json_encode(['success'=>true,'items'=>[],'total'=>0]); exit; }

    $stmt = $conn->prepare("
        SELECT c.id AS cart_id, c.quantity,
               p.id AS product_id, p.name, p.price, p.image,
               v.name     AS vendor_name,
               v.phone    AS vendor_phone,
               v.email    AS vendor_email,
               v.whatsapp AS vendor_whatsapp,
               v.location AS vendor_location
        FROM   cart c
        JOIN   products p ON c.product_id = p.id
        JOIN   vendors  v ON p.vendor_id  = v.id
        WHERE  c.user_id = ?
        ORDER  BY c.created_at DESC
    ");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $total = 0;
    foreach ($rows as &$r) {
        $r['subtotal'] = $r['price'] * $r['quantity'];
        $total += $r['subtotal'];
    }
    echo json_encode(['success'=>true,'items'=>$rows,'total'=>$total]);
    exit;
}

// ── ADD ───────────────────────────────────────
if ($action === 'add') {
    if (!$user_id) needLogin();
    $pid = intval($_POST['product_id'] ?? 0);
    $qty = max(1, intval($_POST['quantity'] ?? 1));

    if (!$pid) { echo json_encode(['success'=>false,'message'=>'Invalid product.']); exit; }

    // Check if already in cart
    $ex = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id=? AND product_id=?");
    $ex->bind_param('ii', $user_id, $pid); $ex->execute();
    $existing = $ex->get_result()->fetch_assoc(); $ex->close();

    if ($existing) {
        $nq = $existing['quantity'] + $qty;
        $u  = $conn->prepare("UPDATE cart SET quantity=? WHERE id=?");
        $u->bind_param('ii', $nq, $existing['id']); $u->execute(); $u->close();
    } else {
        $i = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?,?,?)");
        $i->bind_param('iii', $user_id, $pid, $qty); $i->execute(); $i->close();
    }
    echo json_encode(['success'=>true,'message'=>'Added to cart!']);
    exit;
}

// ── UPDATE quantity ───────────────────────────
if ($action === 'update') {
    if (!$user_id) needLogin();
    $cid = intval($_POST['cart_id']  ?? 0);
    $qty = intval($_POST['quantity'] ?? 1);
    if ($qty < 1) {
        $d = $conn->prepare("DELETE FROM cart WHERE id=? AND user_id=?");
        $d->bind_param('ii',$cid,$user_id); $d->execute(); $d->close();
        echo json_encode(['success'=>true,'removed'=>true]); exit;
    }
    $u = $conn->prepare("UPDATE cart SET quantity=? WHERE id=? AND user_id=?");
    $u->bind_param('iii',$qty,$cid,$user_id); $u->execute(); $u->close();
    echo json_encode(['success'=>true]); exit;
}

// ── REMOVE ────────────────────────────────────
if ($action === 'remove') {
    if (!$user_id) needLogin();
    $cid = intval($_POST['cart_id'] ?? 0);
    $d = $conn->prepare("DELETE FROM cart WHERE id=? AND user_id=?");
    $d->bind_param('ii',$cid,$user_id); $d->execute(); $d->close();
    echo json_encode(['success'=>true,'message'=>'Item removed.']); exit;
}

echo json_encode(['success'=>false,'message'=>'Unknown action.']);
$conn->close();
?>
