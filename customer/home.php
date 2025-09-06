<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FarmBasket - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-[#D2B48C]">

<?php include 'navbar.php'; ?>

<section>
  <img src="../images/home.jpg" alt="Farm Field" class="w-full h-80 object-cover">
</section>


<section class="bg-[#D2B48C] text-gray-900 py-24 shadow-lg">
  <div class="container mx-auto px-6 text-center">
    <h1 class="text-4xl md:text-5xl font-bold mb-6">
    Grow More, Worry Less —
      <span class="text-green-800">FarmBasket</span> Delivers Success!
    </h1>
    <p class="text-lg md:text-xl mb-8 text-gray-700">
      From quality seeds to trusted supplies, we help your farm thrive.
    </p>
    <a href="product.php" 
       class="bg-green-700 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-800 transition">
       Explore Products
    </a>
  </div>
</section>
<hr class="border-t-2 border-black mx-20">


<section class="py-16 bg-[#D2B48C]">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Why Choose FarmBasket?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      
      
      <div class="bg-[#c0a891] shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
        <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center">
          <img src="../images/seeds-home.png" alt="Seeds Icon" class="w-full h-full object-contain">
        </div>
        <h3 class="text-xl font-semibold mb-2">Quality Seeds</h3>
        <p class="text-gray-600">Top-grade seeds for maximum yield and healthy crops.</p>
      </div>


      <div class="bg-[#c0a891] shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
        <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center">
          <img src="../images/pest-home.png" alt="Pesticide Icon" class="w-full h-full object-contain">
        </div>
        <h3 class="text-xl font-semibold mb-2">Safe Pesticides</h3>
        <p class="text-gray-600">Organic and safe solutions to protect your farm naturally.</p>
      </div>


      <div class="bg-[#c0a891] shadow-md rounded-lg p-6 text-center hover:shadow-lg transition">
        <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center">
          <img src="../images/delivery.png" alt="Delivery Icon" class="w-full h-full object-contain">
        </div>
        <h3 class="text-xl font-semibold mb-2">Fast Delivery</h3>
        <p class="text-gray-600">Quick and reliable delivery, right to your farm or doorstep.</p>
      </div>

    </div>
  </div>
</section>
<?php include 'footer.php'; ?>

</body>
</html>
