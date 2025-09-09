<?php include __DIR__ . "/partials/header.php"; ?>
<section class="grid md:grid-cols-2 gap-6 items-center">
  <div>
    <h1 class="text-4xl font-extrabold mb-3">Seeds & Pesticides for Smart Farmers</h1>
    <p class="text-slate-700 mb-4">FarmBaskets is a beginner-friendly ecommerce project where customers, suppliers, and admins each have their own dashboards. Browse products, add to cart, checkout, and view reports.</p>
    <div class="flex gap-3">
      <a href="/FarmBaskets/customer/products.php" class="px-4 py-2 rounded bg-green-700 text-white hover:bg-green-800">Start Shopping</a>
      <a href="/FarmBaskets/auth/register.php?role=supplier" class="px-4 py-2 rounded border border-green-700 text-green-700 hover:bg-green-50">Become a Supplier</a>
    </div>
  </div>
  <div class="rounded-2xl p-6 bg-white shadow">
    <h2 class="text-xl font-semibold mb-3">Featured Products</h2>
    <div class="grid grid-cols-2 gap-4">
      <?php
      $res = $conn->query("SELECT id,name,price,image_url FROM products WHERE is_active=1 ORDER BY id DESC LIMIT 4");
      while($p = $res && $res->fetch_assoc()) { }
      // Fetch again because while consumed $res->fetch_assoc() in condition above by mistake; do a fresh query simple way for demo:
      $res = $conn->query("SELECT id,name,price,image_url FROM products WHERE is_active=1 ORDER BY id DESC LIMIT 4");
      while($p = $res->fetch_assoc()): ?>
        <a class="border rounded-xl p-3 hover:shadow" href="/FarmBaskets/customer/products.php#p<?php echo $p['id'];?>">
          <img class="w-full h-28 object-cover rounded-lg" src="<?php echo htmlspecialchars($p['image_url'] ?: 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?w=800&q=80');?>" alt=""/>
          <div class="mt-2 font-medium"><?php echo htmlspecialchars($p['name']);?></div>
          <div class="text-sm text-slate-600">₹<?php echo number_format($p['price'],2);?></div>
        </a>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php include __DIR__ . "/partials/footer.php"; ?>
