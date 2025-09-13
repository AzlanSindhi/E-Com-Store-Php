<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON c.id = p.category_id WHERE p.id = :id AND p.is_active = 1");
$stmt->execute([':id'=>$id]);
$p = $stmt->fetch();
if (!$p) { header("Location: index.php"); exit; }

// add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $qty = max(1, (int)($_POST['qty'] ?? 1));
  $_SESSION['cart'] = $_SESSION['cart'] ?? [];
  if (!isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] = ['id'=>$id, 'name'=>$p['name'], 'price'=>$p['price'], 'qty'=>$qty, 'image'=>$p['image_url']];
  } else {
    $_SESSION['cart'][$id]['qty'] += $qty;
  }
  header("Location: cart.php");
  exit;
}

include __DIR__ . '/includes/header.php';
?>
<div class="row g-4">
  <div class="col-md-6">
    <img src="<?= htmlspecialchars($p['image_url']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($p['name']) ?>">
  </div>
  <div class="col-md-6">
    <span class="badge badge-soft mb-2"><?= htmlspecialchars($p['category_name']) ?></span>
    <h2 class="fw-bold"><?= htmlspecialchars($p['name']) ?></h2>
    <p class="text-muted"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
    <div class="d-flex align-items-center mb-3">
      <span class="price display-6 me-3">₹<?= number_format($p['price'], 2) ?></span>
      <small class="text-muted">(incl. GST)</small>
    </div>
    <form method="post" class="row g-2">
      <div class="col-4 col-md-3">
        <input type="number" min="1" value="1" name="qty" class="form-control">
      </div>
      <div class="col-8 col-md-5 d-grid">
        <button class="btn btn-success btn-lg">Add to Cart</button>
      </div>
    </form>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
