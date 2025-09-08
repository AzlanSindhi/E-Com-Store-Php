<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.php"); // go back to login
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Farm'sBasket — Customer Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-100 text-slate-800">

<!-- Header -->
<header class="bg-white shadow sticky top-0 z-40">
  <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
    <h1 class="text-xl font-bold text-green-700">Farm'sBasket</h1>
    <nav class="flex gap-4">
      <a href="../index.php" class="hover:text-green-700">Home</a>
      <a href="?cat=seeds" class="hover:text-green-700">Seeds</a>
      <a href="?cat=pesticides" class="hover:text-green-700">Pesticides</a>
      <a href="orders.php" class="hover:text-green-700">My Orders</a>
      <a href="../logout.php" class="text-red-600 hover:text-red-800">Logout</a>
    </nav>
  </div>
</header>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 py-10">
  <h2 class="text-2xl font-semibold mb-6">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> 👋</h2>

  <!-- Quick Actions -->
  <div class="grid md:grid-cols-3 gap-6">
    <a href="?cat=seeds" class="p-6 bg-white rounded-2xl shadow hover:shadow-lg border text-center">
      <h3 class="text-lg font-semibold text-green-700">Shop Seeds</h3>
      <p class="text-sm text-slate-600 mt-2">Browse high-yield and organic seeds curated for farmers.</p>
    </a>

    <a href="?cat=pesticides" class="p-6 bg-white rounded-2xl shadow hover:shadow-lg border text-center">
      <h3 class="text-lg font-semibold text-green-700">Shop Pesticides</h3>
      <p class="text-sm text-slate-600 mt-2">Explore effective pest control solutions for your crops.</p>
    </a>

    <a href="orders.php" class="p-6 bg-white rounded-2xl shadow hover:shadow-lg border text-center">
      <h3 class="text-lg font-semibold text-green-700">My Orders</h3>
      <p class="text-sm text-slate-600 mt-2">Track your order history and status updates here.</p>
    </a>
  </div>
</main>

</body>
</html>
