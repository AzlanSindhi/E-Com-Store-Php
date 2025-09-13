<?php
require_once __DIR__ . '/config.php';
include __DIR__ . '/includes/header.php';
$id = (int)($_GET['id'] ?? 0);
?>
<div class="text-center py-5">
  <h1 class="display-5">🎉 Order Placed!</h1>
  <p class="lead">Your order #<?= $id ?> has been placed successfully. We'll contact you soon.</p>
  <a class="btn btn-success" href="index.php">Back to Shop</a>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
