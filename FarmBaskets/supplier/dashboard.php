<?php
require_once __DIR__ . "/../partials/header.php";
require_role('supplier');
$sid = intval($_SESSION['user']['id']);
$prodCount = $conn->query("SELECT COUNT(*) c FROM products WHERE supplier_id=$sid")->fetch_assoc()['c'] ?? 0;
$sales = $conn->query("SELECT COALESCE(SUM(oi.quantity*oi.unit_price),0) s FROM order_items oi JOIN products p ON p.id=oi.product_id WHERE p.supplier_id=$sid")->fetch_assoc()['s'] ?? 0;
?>
<h2 class="text-2xl font-bold mb-4">Supplier Dashboard</h2>
<div class="grid md:grid-cols-3 gap-4">
  <div class="bg-white rounded-xl shadow p-4"><div class="text-sm text-slate-600">Products</div><div class="text-3xl font-bold"><?php echo $prodCount;?></div></div>
  <div class="bg-white rounded-xl shadow p-4"><div class="text-sm text-slate-600">Total Sales</div><div class="text-3xl font-bold">₹<?php echo number_format($sales,2);?></div></div>
  <div class="bg-white rounded-xl shadow p-4"><div class="text-sm text-slate-600">Status</div><div class="text-xl font-semibold">Approved ✅</div></div>
</div>
<div class="mt-6 flex gap-3">
  <a class="px-3 py-2 rounded bg-green-700 text-white" href="products.php">Manage Products</a>
  <a class="px-3 py-2 rounded border border-green-700 text-green-700" href="reports.php">Reports</a>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
