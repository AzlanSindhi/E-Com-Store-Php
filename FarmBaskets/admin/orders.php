<?php
require_once __DIR__ . "/../partials/header.php";
require_role('admin');
if (isset($_GET['status'], $_GET['id'])) {
    $id = intval($_GET['id']);
    $st = esc($_GET['status']);
    $conn->query("UPDATE orders SET status='$st' WHERE id=$id");
    header("Location: orders.php"); exit;
}
$res = $conn->query("SELECT * FROM orders ORDER BY id DESC");
?>
<h2 class="text-2xl font-bold mb-4">Orders</h2>
<div class="bg-white rounded-xl shadow overflow-hidden">
<table class="w-full text-sm">
  <thead class="bg-slate-100"><tr><th class="text-left p-2">Order</th><th>Customer</th><th>Total</th><th>Status</th><th>Action</th></tr></thead>
  <tbody>
  <?php while($o=$res->fetch_assoc()): 
    $cu = $conn->query("SELECT name FROM users WHERE id=".$o['customer_id'])->fetch_assoc()['name'] ?? 'Unknown'; ?>
    <tr class="border-t">
      <td class="p-2">#<?php echo $o['id'];?></td>
      <td class="text-center"><?php echo htmlspecialchars($cu);?></td>
      <td class="text-center">₹<?php echo number_format($o['total_amount'],2);?></td>
      <td class="text-center"><?php echo htmlspecialchars($o['status']);?></td>
      <td class="text-center">
        <a class="text-blue-600 hover:underline" href="?id=<?php echo $o['id'];?>&status=shipped">Mark Shipped</a> • 
        <a class="text-green-700 hover:underline" href="?id=<?php echo $o['id'];?>&status=completed">Complete</a>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
