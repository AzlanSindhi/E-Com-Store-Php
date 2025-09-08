<?php
// products.php — List all products with filters

session_start();

// DB connection
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'farmsbasket';
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

// Helpers
function esc($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
function money($n) { return '₹' . number_format($n, 2); }

// Get categories
$cats = $conn->query("SELECT * FROM categories ORDER BY name")->fetch_all(MYSQLI_ASSOC);

// Get selected category
$category = trim($_GET['cat'] ?? '');

// Get products
$sql = "SELECT p.id, p.name, p.price, p.unit, p.image_url, c.name AS category, c.slug
        FROM products p
        JOIN categories c ON c.id = p.category_id
        WHERE p.is_active=1";
if ($category) {
  $sql .= " AND c.slug='" . $conn->real_escape_string($category) . "'";
}
$sql .= " ORDER BY p.created_at DESC";
$products = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Products — Farm'sBasket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 via-white to-green-100 text-slate-800">

<!-- Header -->
<?php include "partials/header.php"; ?>

<!-- Page Title -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
  <h1 class="text-3xl font-bold text-green-700 mb-6">Our Products</h1>

  <!-- Category Filter -->
  <div class="flex flex-wrap gap-2 mb-8">
    <a href="products.php" class="px-4 py-2 rounded-full border border-emerald-200 <?php echo $category===''?'bg-green-600 text-white':'hover:bg-emerald-50'; ?>">All</a>
    <?php foreach ($cats as $c): ?>
      <a href="products.php?cat=<?php echo esc($c['slug']); ?>" 
         class="px-4 py-2 rounded-full border border-emerald-200 <?php echo $category===$c['slug']?'bg-green-600 text-white':'hover:bg-emerald-50'; ?>">
        <?php echo esc($c['name']); ?>
      </a>
    <?php endforeach; ?>
  </div>

  <!-- Product Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <?php if (!$products): ?>
      <div class="sm:col-span-2 lg:col-span-3 xl:col-span-4 text-slate-500">
        No products found in this category.
      </div>
    <?php endif; ?>

    <?php foreach ($products as $p): ?>
      <div class="group rounded-2xl overflow-hidden bg-white ring-1 ring-emerald-100 hover:ring-green-300 shadow-sm hover:shadow-lg transition">
        <div class="aspect-[4/3] overflow-hidden">
          <img src="<?php echo esc($p['image_url']); ?>" alt="<?php echo esc($p['name']); ?>" class="w-full h-full object-cover group-hover:scale-[1.05] transition"/>
        </div>
        <div class="p-4">
          <div class="text-xs text-emerald-700/80"><?php echo esc($p['category']); ?></div>
          <h3 class="mt-1 font-semibold leading-snug"><?php echo esc($p['name']); ?></h3>
          <div class="mt-2 flex items-center justify-between">
            <div class="text-green-700 font-semibold"><?php echo money((float)$p['price']); ?></div>
            <div class="text-sm text-slate-500"><?php echo esc($p['unit']); ?></div>
          </div>
          <button class="mt-4 w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Add to Cart</button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Footer -->
<?php include "partials/footer.php"; ?>

</body>
</html>
