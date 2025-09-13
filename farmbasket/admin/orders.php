<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin'])) { header("Location: index.php"); exit; }

$orders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll();
include __DIR__ . '/../includes/header.php';
?>
<h2>Orders</h2>
<div class="table-responsive">
<table class="table align-middle">
  <thead>
    <tr><th>#</th><th>Customer</th><th>Phone</th><th>Address</th><th>Total</th><th>Placed</th></tr>
  </thead>
  <tbody>
    <?php foreach ($orders as $o): ?>
      <tr>
        <td><?= $o['id'] ?></td>
        <td><?= htmlspecialchars($o['customer_name']) ?></td>
        <td><?= htmlspecialchars($o['phone']) ?></td>
        <td><?= nl2br(htmlspecialchars($o['address'])) ?></td>
        <td>₹<?= number_format($o['total'],2) ?></td>
        <td><?= $o['created_at'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
