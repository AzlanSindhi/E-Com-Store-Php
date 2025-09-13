<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin'])) { header("Location: index.php"); exit; }
include __DIR__ . '/../includes/header.php';

$stats = [
  'products' => $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(),
  'orders' => $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
  'sales' => $pdo->query("SELECT COALESCE(SUM(total),0) FROM orders")->fetchColumn()
];
?>
<h2 class="mb-4">Admin Dashboard</h2>
<div class="row g-3">
  <div class="col-md-4"><div class="card p-4 text-center">
    <div class="fs-1">🌱</div><div class="fw-bold">Products</div><div class="display-6"><?= $stats['products'] ?></div></div></div>
  <div class="col-md-4"><div class="card p-4 text-center">
    <div class="fs-1">🧾</div><div class="fw-bold">Orders</div><div class="display-6"><?= $stats['orders'] ?></div></div></div>
  <div class="col-md-4"><div class="card p-4 text-center">
    <div class="fs-1">₹</div><div class="fw-bold">Total Sales</div><div class="display-6">₹<?= number_format($stats['sales'],2) ?></div></div></div>
</div>

<div class="mt-4 d-flex gap-2">
  <a class="btn btn-success" href="products.php">Manage Products</a>
  <a class="btn btn-outline-secondary" href="orders.php">View Orders</a>
  <a class="btn btn-link" href="logout.php">Logout</a>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
