<?php
// partials/header.php
require_once __DIR__ . "/../config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FarmBaskets</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900">
<header class="bg-green-700 text-white">
  <div class="max-w-6xl mx-auto flex items-center justify-between p-4">
    <a href="/FarmBaskets/index.php" class="font-bold text-xl tracking-wide">🌱 FarmBaskets</a>
    <nav class="flex items-center gap-3">
      <a class="hover:underline" href="/FarmBaskets/index.php">Home</a>
      <a class="hover:underline" href="/FarmBaskets/customer/products.php">Shop</a>
      <?php if (is_logged_in() && user_role()==='customer'): ?>
        <a class="hover:underline" href="/FarmBaskets/customer/cart.php">Cart</a>
        <a class="hover:underline" href="/FarmBaskets/customer/orders.php">My Orders</a>
      <?php endif; ?>
      <?php if (is_logged_in() && user_role()==='supplier'): ?>
        <a class="hover:underline" href="/FarmBaskets/supplier/dashboard.php">Supplier</a>
      <?php endif; ?>
      <?php if (is_logged_in() && user_role()==='admin'): ?>
        <a class="hover:underline" href="/FarmBaskets/admin/dashboard.php">Admin</a>
      <?php endif; ?>
      <?php if (!is_logged_in()): ?>
        <div class="relative group">
          <button class="px-3 py-1 rounded bg-white/10 hover:bg-white/20">Login</button>
          <div class="absolute right-0 mt-2 hidden group-hover:block bg-white text-slate-800 rounded shadow-lg">
            <a class="block px-4 py-2 hover:bg-slate-100" href="/FarmBaskets/auth/login.php?role=customer">Customer</a>
            <a class="block px-4 py-2 hover:bg-slate-100" href="/FarmBaskets/auth/login.php?role=supplier">Supplier</a>
            <a class="block px-4 py-2 hover:bg-slate-100" href="/FarmBaskets/auth/login.php?role=admin">Admin</a>
          </div>
        </div>
        <div class="relative group">
          <button class="px-3 py-1 rounded bg-white/10 hover:bg-white/20">Register</button>
          <div class="absolute right-0 mt-2 hidden group-hover:block bg-white text-slate-800 rounded shadow-lg">
            <a class="block px-4 py-2 hover:bg-slate-100" href="/FarmBaskets/auth/register.php?role=customer">Customer</a>
            <a class="block px-4 py-2 hover:bg-slate-100" href="/FarmBaskets/auth/register.php?role=supplier">Supplier</a>
            <a class="block px-4 py-2 hover:bg-slate-100" href="/FarmBaskets/auth/register.php?role=admin">Admin</a>
          </div>
        </div>
      <?php else: ?>
        <form action="/FarmBaskets/auth/logout.php" method="post">
          <button class="px-3 py-1 rounded bg-white/10 hover:bg-white/20">Logout</button>
        </form>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="max-w-6xl mx-auto p-4">
<?php if ($msg = flash('info')): ?>
  <div class="mb-4 p-3 rounded bg-green-100 text-green-800"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>
<?php if ($msg = flash('error')): ?>
  <div class="mb-4 p-3 rounded bg-red-100 text-red-800"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>
