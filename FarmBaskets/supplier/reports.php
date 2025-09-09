<?php
require_once __DIR__ . "/../partials/header.php";
require_role('supplier');
$sid = intval($_SESSION['user']['id']);
$top = $conn->query("
  SELECT p.name, SUM(oi.quantity) qty, SUM(oi.quantity*oi.unit_price) revenue
  FROM order_items oi
  JOIN products p ON p.id=oi.product_id
  WHERE p.supplier_id=$sid
  GROUP BY p.id
  ORDER BY revenue DESC
");
?>
<h2 class="text-2xl font-bold mb-4">Reports</h2>
<div class="bg-white rounded-xl shadow p-4">
  <h3 class="font-semibold mb-2">Top Products</h3>
  <table class="w-full text-sm">
    <thead class="bg-slate-100"><tr><th class="text-left p-2">Product</th><th>Qty Sold</th><th>Revenue</th></tr></thead>
    <tbody>
      <?php while($r=$top->fetch_assoc()): ?>
        <tr class="border-t">
          <td class="p-2"><?php echo htmlspecialchars($r['name']);?></td>
          <td class="text-center"><?php echo intval($r['qty']);?></td>
          <td class="text-center">₹<?php echo number_format($r['revenue'],2);?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
