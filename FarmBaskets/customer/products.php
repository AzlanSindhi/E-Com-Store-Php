<?php
require_once __DIR__ . "/../partials/header.php";
?>
<h2 class="text-2xl font-bold mb-4">All Products</h2>
<div class="grid md:grid-cols-3 gap-4">
<?php
$res = $conn->query("SELECT * FROM products WHERE is_active=1 ORDER BY id DESC");
while($p = $res->fetch_assoc()): ?>
  <div id="p<?php echo $p['id'];?>" class="bg-white rounded-xl shadow p-3 flex flex-col">
    <img class="w-full h-40 object-cover rounded-lg" src="<?php echo htmlspecialchars($p['image_url']);?>" alt=""/>
    <div class="mt-2 font-semibold"><?php echo htmlspecialchars($p['name']);?></div>
    <div class="text-sm text-slate-600 mb-3">₹<?php echo number_format($p['price'],2);?> • Stock: <?php echo intval($p['stock']);?></div>
    <form method="post" action="cart.php" class="mt-auto flex gap-2">
      <input type="hidden" name="product_id" value="<?php echo $p['id'];?>"/>
      <input type="number" class="w-20 border rounded p-2" name="qty" min="1" max="<?php echo intval($p['stock']);?>" value="1"/>
      <button class="px-3 py-2 rounded bg-green-700 text-white hover:bg-green-800">Add to Cart</button>
    </form>
  </div>
<?php endwhile; ?>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
