<?php
// admin/dashboard.php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit;
}

// DB connection
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'farmsbasket';
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Quick stats
$stats = [
    'customers' => $conn->query("SELECT COUNT(*) AS c FROM users WHERE role_id=(SELECT id FROM roles WHERE name='customer')")->fetch_assoc()['c'],
    'suppliers' => $conn->query("SELECT COUNT(*) AS c FROM suppliers")->fetch_assoc()['c'],
    'products'  => $conn->query("SELECT COUNT(*) AS c FROM products")->fetch_assoc()['c'],
    'orders'    => rand(25, 120) // fake orders count (replace with orders table later)
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard — Farm'sBasket</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen bg-gray-100 text-gray-800">

<!-- Sidebar -->
<aside class="w-64 bg-gradient-to-b from-green-700 to-green-900 text-white flex flex-col">
  <div class="p-6 text-center border-b border-green-600">
    <h1 class="text-2xl font-bold">🌾 Farm'sBasket</h1>
    <p class="text-sm text-green-200">Admin Panel</p>
  </div>
  <nav class="flex-1 p-4 space-y-2">
    <a href="dashboard.php" class="block px-4 py-2 rounded bg-green-800">📊 Dashboard</a>
    <a href="manage_users.php" class="block px-4 py-2 rounded hover:bg-green-800">👤 Manage Users</a>
    <a href="manage_products.php" class="block px-4 py-2 rounded hover:bg-green-800">🌱 Manage Products</a>
    <a href="manage_suppliers.php" class="block px-4 py-2 rounded hover:bg-green-800">🚚 Manage Suppliers</a>
    <a href="reports.php" class="block px-4 py-2 rounded hover:bg-green-800">📑 Reports</a>
  </nav>
  <div class="p-4 border-t border-green-600">
    <a href="../logout.php" class="block px-4 py-2 rounded text-red-300 hover:bg-red-600 hover:text-white">Logout</a>
  </div>
</aside>

<!-- Main -->
<main class="flex-1 p-8">
  <!-- Top bar -->
  <div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-bold">Welcome back, <?php echo htmlspecialchars($_SESSION['user']['name']); ?> 👋</h2>
    <span class="text-gray-600">Role: <span class="font-semibold">Admin</span></span>
  </div>

  <!-- Stats cards -->
  <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg">
      <h3 class="text-lg font-semibold text-green-700">Customers</h3>
      <p class="text-3xl font-bold mt-2"><?= $stats['customers'] ?></p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg">
      <h3 class="text-lg font-semibold text-green-700">Suppliers</h3>
      <p class="text-3xl font-bold mt-2"><?= $stats['suppliers'] ?></p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg">
      <h3 class="text-lg font-semibold text-green-700">Products</h3>
      <p class="text-3xl font-bold mt-2"><?= $stats['products'] ?></p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg">
      <h3 class="text-lg font-semibold text-green-700">Orders</h3>
      <p class="text-3xl font-bold mt-2"><?= $stats['orders'] ?></p>
    </div>
  </div>

  <!-- Quick links -->
  <div class="grid md:grid-cols-2 gap-6">
    <a href="manage_users.php" class="p-8 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl shadow hover:shadow-lg transition">
      <h3 class="text-xl font-semibold">👤 Manage Users</h3>
      <p class="text-sm text-green-100 mt-2">View, edit, or remove customers and other accounts.</p>
    </a>
    <a href="manage_products.php" class="p-8 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl shadow hover:shadow-lg transition">
      <h3 class="text-xl font-semibold">🌱 Manage Products</h3>
      <p class="text-sm text-green-100 mt-2">Add, update, or deactivate seeds and pesticides.</p>
    </a>
    <a href="manage_suppliers.php" class="p-8 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl shadow hover:shadow-lg transition">
      <h3 class="text-xl font-semibold">🚚 Manage Suppliers</h3>
      <p class="text-sm text-green-100 mt-2">Track and connect with suppliers for inventory.</p>
    </a>
    <a href="reports.php" class="p-8 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl shadow hover:shadow-lg transition">
      <h3 class="text-xl font-semibold">📑 Reports</h3>
      <p class="text-sm text-green-100 mt-2">Check sales performance, customer insights, and more.</p>
    </a>
  </div>
</main>

</body>
</html>
