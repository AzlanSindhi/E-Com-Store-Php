<?php
// index.php — Completed Elegant Home Page for Farm’sBasket (Seeds & Pesticides Only)

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

function esc($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
function money($n) { return '₹' . number_format($n, 2); }

$q = trim($_GET['q'] ?? '');
$category = trim($_GET['cat'] ?? '');

$sql = "SELECT p.id, p.name, p.price, p.unit, p.image_url, c.name AS category
        FROM products p
        JOIN categories c ON c.id = p.category_id
        WHERE p.is_active = 1";
if ($category !== '') {
  $sql .= " AND c.slug='" . $conn->real_escape_string($category) . "'";
}
if ($q !== '') {
  $q_esc = $conn->real_escape_string($q);
  $sql .= " AND (p.name LIKE '%$q_esc%' OR p.description LIKE '%$q_esc%')";
}
$sql .= " ORDER BY p.created_at DESC LIMIT 12";
$products = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Farm'sBasket — Seeds & Pesticides</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] }, colors: { brand: { 50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b' } } } } };</script>
<style>.glass{backdrop-filter:saturate(180%) blur(12px); background:rgba(255,255,255,.65);}</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-brand-50 via-white to-brand-100 text-slate-800">

<!-- Header -->
<header class="sticky top-0 z-40">
  <div class="glass border-b border-emerald-100/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
      
      <!-- Logo -->
      <a href="index.php" class="flex items-center gap-2 group">
        <img src="assets/logo.svg" alt="Farm'sBasket" class="w-9 h-9"/>
        <span class="text-xl font-semibold tracking-tight group-hover:text-brand-700 transition">Farm'sBasket</span>
      </a>

      <!-- Desktop Nav -->
      <nav class="hidden md:flex items-center gap-6">
        <a href="index.php" class="hover:text-brand-700">Home</a>
        <a href="products.php" class="hover:text-brand-700">Products</a>
        <a href="supplier/register.php" class="hover:text-brand-700">Become Seller</a>
      </nav>

      <!-- Right Actions -->
      <div class="flex items-center gap-3">
        <!-- Cart Icon -->
        <a href="customer/cart.php" class="relative hover:text-brand-700">
          🛒
          <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
            <?php echo $_SESSION['cart_count'] ?? 0; ?>
          </span>
        </a>

        <!-- Auth Buttons -->
        <a href="login.php" class="hidden sm:inline text-sm px-3 py-1.5 rounded-full border border-emerald-200 hover:bg-emerald-50">Sign in</a>
        <a href="register.php" class="hidden sm:inline text-sm px-4 py-1.5 rounded-full bg-brand-600 text-white hover:bg-brand-700 shadow">Create account</a>

        <!-- Mobile Menu Button -->
        <button id="menu-btn" class="md:hidden p-2 rounded-lg border border-emerald-200 hover:bg-emerald-50">
          ☰
        </button>
      </div>
    </div>

    <!-- Mobile Nav -->
    <div id="mobile-menu" class="hidden md:hidden px-4 pb-4 space-y-2">
      <a href="index.php" class="block hover:text-brand-700">Home</a>
      <a href="?cat=products" class="block hover:text-brand-700">Products</a>
      <a href="seller/register.php" class="block hover:text-brand-700">Become Seller</a>
      <a href="login.php" class="block hover:text-brand-700">Sign in</a>
      <a href="register.php" class="block hover:text-brand-700">Create account</a>
    </div>
  </div>
</header>

<script>
  const menuBtn = document.getElementById("menu-btn");
  const menu = document.getElementById("mobile-menu");
  menuBtn.addEventListener("click", () => {
    menu.classList.toggle("hidden");
  });
</script>


<!-- Hero -->
<section class="relative overflow-hidden">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
<div class="grid md:grid-cols-2 gap-10 items-center">
<div>
<h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight">
Fresh yields start with <span class="text-brand-700">better inputs</span>
</h1>
<p class="mt-4 text-slate-600 max-w-prose">Shop certified seeds and effective pesticides — curated for Indian farms. Transparent pricing, real availability.</p>
<form method="get" class="mt-6 flex gap-2">
<input type="text" name="q" value="<?php echo esc($q); ?>" placeholder="Search seeds, pesticides…" class="w-full md:w-2/3 px-4 py-3 rounded-xl border border-emerald-200 focus:outline-none focus:ring-2 focus:ring-brand-400 bg-white/90"/>
<button class="px-5 py-3 rounded-xl bg-brand-600 text-white hover:bg-brand-700 shadow">Search</button>
</form>
<?php if ($q !== ''): ?>
<p class="mt-2 text-sm text-slate-500">Showing results for <strong>“<?php echo esc($q); ?>”</strong></p>
<?php endif; ?>
</div>
<div class="relative">
<div class="aspect-[4/3] rounded-3xl shadow-2xl ring-1 ring-emerald-200 overflow-hidden">
<img src="https://images.unsplash.com/photo-1604335399105-0d7bf1e9c5a1?q=80&w=1600&auto=format&fit=crop" alt="Field" class="w-full h-full object-cover"/>
</div>
<div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-lg border border-emerald-100 p-4">
<p class="text-sm">Trusted by <span class="font-semibold">10,000+ growers</span></p>
</div>
</div>
</div>
</div>
</section>

<!-- Category Pills -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex flex-wrap gap-2">
<a href="?" class="px-4 py-2 rounded-full border border-emerald-200 <?php echo $category===''? 'bg-brand-600 text-white' : 'hover:bg-emerald-50'; ?>">All</a>
<a href="?cat=seeds" class="px-4 py-2 rounded-full border border-emerald-200 <?php echo $category==='seeds'? 'bg-brand-600 text-white' : 'hover:bg-emerald-50'; ?>">Seeds</a>
<a href="?cat=pesticides" class="px-4 py-2 rounded-full border border-emerald-200 <?php echo $category==='pesticides'? 'bg-brand-600 text-white' : 'hover:bg-emerald-50'; ?>">Pesticides</a>
</div>
</section>

<!-- Product Grid -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
<div class="flex items-center justify-between mb-6">
<h2 class="text-xl font-semibold">Featured products</h2>
<a href="#" class="text-sm hover:text-brand-700">View all</a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
<?php if (!$products): ?>
<div class="sm:col-span-2 lg:col-span-3 xl:col-span-4 text-slate-500">
No products found. Try clearing filters or add seed data.
</div>
<?php endif; ?>

<?php foreach ($products as $p): ?>
<a href="#" class="group rounded-2xl overflow-hidden bg-white ring-1 ring-emerald-100 hover:ring-brand-300 shadow-sm hover:shadow-lg transition">
<div class="aspect-[4/3] overflow-hidden">
<img src="<?php echo esc($p['image_url']); ?>" alt="<?php echo esc($p['name']); ?>" class="w-full h-full object-cover group-hover:scale-[1.03] transition"/>
</div>
<div class="p-4">
<div class="text-xs text-emerald-700/80"><?php echo esc($p['category']); ?></div>
<h3 class="mt-1 font-semibold leading-snug"><?php echo esc($p['name']); ?></h3>
<div class="mt-2 flex items-center justify-between">
<div class="text-brand-700 font-semibold"><?php echo money((float)$p['price']); ?></div>
<div class="text-sm text-slate-500"><?php echo esc($p['unit']); ?></div>
</div>
</div>
</a>
<?php endforeach; ?>
</div>
</section>

<!-- Footer -->
<footer class="border-t border-emerald-200/70">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-sm text-slate-600 flex flex-col sm:flex-row gap-4 sm:items-center sm:justify-between">
<p>© <?php echo date('Y'); ?> Farm'sBasket. All rights reserved.</p>
<div class="flex gap-4">
<a href="#" class="hover:text-brand-700">About</a>
<a href="#" class="hover:text-brand-700">Contact</a>
</div>
</div>
</footer>
</body>
</html>