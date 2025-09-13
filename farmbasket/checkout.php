<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$cart = $_SESSION['cart'] ?? [];
if (!$cart) { header("Location: index.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $address = trim($_POST['address'] ?? '');
  if ($name && $phone && $address) {
    $pdo->beginTransaction();
    try {
      $subtotal = 0;
      foreach ($cart as $it) $subtotal += $it['qty']*$it['price'];
      $gst = $subtotal * 0.05;
      $total = $subtotal + $gst;

      $stmt = $pdo->prepare("INSERT INTO orders (customer_name, phone, address, subtotal, tax, total) VALUES (?,?,?,?,?,?)");
      $stmt->execute([$name, $phone, $address, $subtotal, $gst, $total]);
      $order_id = $pdo->lastInsertId();

      $oi = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, price, qty) VALUES (?,?,?,?,?)");
      foreach ($cart as $id=>$it) {
        $oi->execute([$order_id, $id, $it['name'], $it['price'], $it['qty']]);
      }
      $pdo->commit();
      $_SESSION['cart'] = [];
      header("Location: thankyou.php?id=" . $order_id);
      exit;
    } catch (Exception $e) {
      $pdo->rollBack();
      $error = $e->getMessage();
    }
  } else {
    $error = "Please fill all fields.";
  }
}

include __DIR__ . '/includes/header.php';
?>
<h2 class="mb-3">Checkout</h2>
<?php if (!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Full Name</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Phone</label>
    <input type="tel" name="phone" class="form-control" required>
  </div>
  <div class="col-12">
    <label class="form-label">Delivery Address</label>
    <textarea name="address" class="form-control" rows="3" required></textarea>
  </div>
  <div class="col-12">
    <div class="alert alert-success">Payment method: Cash on Delivery</div>
  </div>
  <div class="col-12">
    <button class="btn btn-success btn-lg">Place Order</button>
  </div>
</form>
<?php include __DIR__ . '/includes/footer.php'; ?>
