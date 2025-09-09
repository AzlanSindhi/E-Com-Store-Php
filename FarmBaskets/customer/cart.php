<?php
require_once __DIR__ . "/../partials/header.php";
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $pid = intval($_POST['product_id'] ?? 0);
    $qty = max(1, intval($_POST['qty'] ?? 1));
    if ($pid>0) {
        $_SESSION['cart'][$pid] = ($_SESSION['cart'][$pid] ?? 0) + $qty;
        flash('info','Added to cart!');
        header("Location: cart.php"); exit;
    }
}
if (isset($_GET['remove'])) {
    $rid = intval($_GET['remove']);
    unset($_SESSION['cart'][$rid]);
    header("Location: cart.php"); exit;
}
$items = $_SESSION['cart'];
$total = 0.0;
?>
<h2 class="text-2xl font-bold mb-4">Your Cart</h2>
<div class="bg-white rounded-xl shadow overflow-hidden">
<table class="w-full">
  <thead class="bg-slate-100"><tr><th class="p-3 text-left">Product</th><th>Qty</th><th>Price</th><th>Subtotal</th><th></th></tr></thead>
  <tbody>
<?php foreach($items as $pid=>$qty):
  $q = $conn->query("SELECT id,name,price FROM products WHERE id=$pid");
  if ($q && $p = $q->fetch_assoc()) {
    $sub = $p['price'] * $qty; $total += $sub; ?>
    <tr class="border-t">
      <td class="p-3"><?php echo htmlspecialchars($p['name']);?></td>
      <td class="text-center"><?php echo intval($qty);?></td>
      <td class="text-center">₹<?php echo number_format($p['price'],2);?></td>
      <td class="text-center font-medium">₹<?php echo number_format($sub,2);?></td>
      <td class="text-center"><a class="text-red-600 hover:underline" href="?remove=<?php echo $pid;?>">Remove</a></td>
    </tr>
<?php } endforeach; ?>
  </tbody>
</table>
</div>
<div class="mt-4 flex justify-between items-center">
  <div class="text-xl font-semibold">Total: ₹<?php echo number_format($total,2);?></div>
  <a href="checkout.php" class="px-4 py-2 rounded bg-green-700 text-white hover:bg-green-800">Proceed to Checkout</a>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
