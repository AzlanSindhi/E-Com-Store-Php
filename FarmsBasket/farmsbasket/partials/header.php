
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

