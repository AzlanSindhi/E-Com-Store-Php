<?php
require_once __DIR__ . "/../partials/header.php";
require_role('customer');
$cid = intval($_SESSION['user']['id']);
$res = $conn->query("SELECT * FROM orders WHERE customer_id=$cid ORDER BY id DESC");
?>
<h2 class="text-2xl font-bold mb-4">My Orders</h2>
<div class="space-y-4">
<?php while($o = $res->fetch_assoc()): ?>
  <div class="bg-white rounded-xl shadow p-4">
    <div class="flex justify-between">
      <div class="font-semibold">Order #<?php echo $o['id']; ?></div>
      <div>Status: <span class="px-2 py-1 rounded bg-slate-100"><?php echo htmlspecialchars($o['status']);?></span></div>
    </div>
    <div class="text-sm text-slate-600">Total: ₹<?php echo number_format($o['total_amount'],2);?> • <?php echo $o['created_at']; ?></div>
    <table class="mt-3 w-full">
      <thead class="text-sm text-slate-600"><tr><th class="text-left">Item</th><th>Qty</th><th>Price</th></tr></thead>
      <tbody>
        <?php
        $it = $conn->query("SELECT oi.quantity,oi.unit_price,p.name FROM order_items oi JOIN products p ON p.id=oi.product_id WHERE oi.order_id=".$o['id']);
        while($i=$it->fetch_assoc()): ?>
          <tr class="border-t"><td class="py-1"><?php echo htmlspecialchars($i['name']);?></td><td class="text-center"><?php echo intval($i['quantity']);?></td><td class="text-center">₹<?php echo number_format($i['unit_price'],2);?></td></tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
<?php endwhile; ?>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
