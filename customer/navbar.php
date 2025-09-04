<nav class="bg-green-700 text-white">
  <div class="container mx-auto px-4 flex items-center justify-between h-16">
    <!-- Logo -->
    <a href="home.php" class="font-bold text-xl">FarmBasket</a>

    <!-- Mobile menu button -->
    <div class="lg:hidden">
      <button id="menu-btn" class="focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>

    <!-- Menu -->
    <ul id="menu" class="hidden lg:flex space-x-6">
      <li><a href="home.php" class="hover:text-green-300 font-medium">Home</a></li>
      <li><a href="product.php" class="hover:text-green-300 font-medium">Products</a></li>
      <li><a href="login.php" class="hover:text-green-300 font-medium">Login</a></li>
      <li><a href="../supplier/supplier_login.php" class="hover:text-green-300 font-medium">Sign in as Supplier</a></li>
    </ul>
  </div>
</nav>

<!-- Mobile Menu Script -->
<script>
  const btn = document.getElementById('menu-btn');
  const menu = document.getElementById('menu');

  btn.addEventListener('click', () => {
    menu.classList.toggle('hidden');
  });
</script>
