<?php
require_once __DIR__ . "/../partials/header.php";
require_role('admin');
$users = $conn->query("SELECT COUNT(*) c FROM users")->fetch_assoc()['c'] ?? 0;
$orders = $conn->query("SELECT COUNT(*) c FROM orders")->fetch_assoc()['c'] ?? 0;
$revenue = $conn->query("SELECT COALESCE(SUM(total_amount),0) s FROM orders")->fetch_assoc()['s'] ?? 0;
?>
<h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>
<div class="grid md:grid-cols-3 gap-4">
  <div class="bg-white rounded-xl shadow p-4"><div class="text-sm text-slate-600">Users</div><div class="text-3xl font-bold"><?php echo $users;?></div></div>
  <div class="bg-white rounded-xl shadow p-4"><div class="text-sm text-slate-600">Orders</div><div class="text-3xl font-bold"><?php echo $orders;?></div></div>
  <div class="bg-white rounded-xl shadow p-4"><div class="text-sm text-slate-600">Revenue</div><div class="text-3xl font-bold">₹<?php echo number_format($revenue,2);?></div></div>
</div>
<div class="mt-6 flex gap-3">
  <a class="px-3 py-2 rounded bg-green-700 text-white" href="users.php">Users</a>
  <a class="px-3 py-2 rounded bg-green-700 text-white" href="products.php">Products</a>
  <a class="px-3 py-2 rounded bg-green-700 text-white" href="suppliers.php">Suppliers</a>
  <a class="px-3 py-2 rounded bg-green-700 text-white" href="orders.php">Orders</a>
  <a class="px-3 py-2 rounded border border-green-700 text-green-700" href="reports.php">Reports</a>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
