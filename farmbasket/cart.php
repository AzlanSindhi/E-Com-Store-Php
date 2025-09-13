<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
include __DIR__ . '/includes/header.php';

// update quantities
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($_POST['qty'] ?? [] as $id=>$q) {
    $q = (int)$q;
    if ($q <= 0) unset($_SESSION['cart'][$id]);
    else $_SESSION['cart'][$id]['qty'] = $q;
  }
  header("Location: cart.php");
  exit;
}

$cart = $_SESSION['cart'] ?? [];
$subtotal = 0;
foreach ($cart as $item) $subtotal += $item['qty'] * $item['price'];
$gst = $subtotal * 0.05;
$total = $subtotal + $gst;
?>
<h2 class="mb-3">Your Cart</h2>
<?php if (!$cart): ?>
<div class="alert alert-info">Your cart is empty. <a href="index.php">Continue shopping</a>.</div>
<?php else: ?>
<form method="post">
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>Item</th><th width="120">Qty</th><th width="160">Price</th><th width="160">Total</th><th width="60"></th></tr></thead>
      <tbody>
        <?php foreach ($cart as $id=>$item): ?>
        <tr>
          <td>
            <div class="d-flex align-items-center gap-3">
              <img src="<?= htmlspecialchars($item['image']) ?>" alt="" width="64" height="64" style="object-fit:cover;" class="rounded">
              <div><?= htmlspecialchars($item['name']) ?></div>
            </div>
          </td>
          <td><input type="number" class="form-control" name="qty[<?= $id ?>]" min="0" value="<?= $item['qty'] ?>"></td>
          <td>₹<?= number_format($item['price'],2) ?></td>
          <td>₹<?= number_format($item['qty']*$item['price'],2) ?></td>
          <td><a class="btn btn-sm btn-outline-danger" href="remove.php?id=<?= $id ?>">✕</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="row g-3 justify-content-end">
    <div class="col-md-4">
      <div class="card p-3">
        <div class="d-flex justify-content-between"><span>Subtotal</span><strong>₹<?= number_format($subtotal,2) ?></strong></div>
        <div class="d-flex justify-content-between"><span>GST (5%)</span><strong>₹<?= number_format($gst,2) ?></strong></div>
        <hr>
        <div class="d-flex justify-content-between fs-5"><span>Total</span><strong>₹<?= number_format($total,2) ?></strong></div>
        <a href="checkout.php" class="btn btn-success btn-lg mt-3 w-100">Checkout</a>
      </div>
    </div>
    <div class="col-md-4">
      <button class="btn btn-outline-secondary">Update quantities</button>
      <a href="index.php" class="btn btn-link">Continue shopping</a>
    </div>
  </div>
</form>
<?php endif; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
