<?php
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0;
$prefix = str_contains($_SERVER['PHP_SELF'], '/admin/') ? '../' : '';
?>
<nav class="navbar navbar-expand-lg shadow-sm sticky-top navbar-glass">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= $prefix ?>index.php">
      <img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/svg/1f331.svg" width="24" alt="leaf" class="me-2"> <?= SITE_NAME ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="<?= $prefix ?>index.php">Shop</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $prefix ?>about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $prefix ?>contact.php">Contact</a></li>
      </ul>
      <div class="d-flex align-items-center gap-3">
        <a href="<?= $prefix ?>cart.php" class="btn btn-sm btn-outline-success position-relative">
          Cart
          <?php if ($cart_count > 0): ?>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success"><?= $cart_count ?></span>
          <?php endif; ?>
        </a>
        <a href="<?= $prefix ?>admin/" class="text-decoration-none small text-muted">Admin</a>
      </div>
    </div>
  </div>
</nav>
