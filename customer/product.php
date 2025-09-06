<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FarmBasket - Categories</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#D2B48C]">

<?php include 'navbar.php'; ?>

<div class="container mx-auto mt-12 px-6">
  <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Choose a Category</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    
    <!-- Seeds Card -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden flex flex-col h-[500px] hover:shadow-2xl transition">
      <img src="../images/seed-product.jpg" alt="Seeds" 
           class="w-full h-2/3 object-contain p-6 bg-gray-50">
      <div class="p-6 flex flex-col justify-center items-center text-center flex-grow">
        <h5 class="text-2xl font-semibold mb-6">Seeds</h5>
        <a href="seeds.php" 
           class="bg-green-700 text-white px-8 py-3 rounded-lg hover:bg-green-800 transition">
           View Seeds
        </a>
      </div>
    </div>
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden flex flex-col h-[500px] hover:shadow-2xl transition">
      <img src="../images/pest-product.webp" alt="Pesticides" 
           class="w-full h-2/3 object-contain p-6 bg-gray-50">
      <div class="p-6 flex flex-col justify-center items-center text-center flex-grow">
        <h5 class="text-2xl font-semibold mb-6">Pesticides</h5>
        <a href="pesticides.php" 
           class="bg-green-700 text-white px-8 py-3 rounded-lg hover:bg-green-800 transition">
           View Pesticides
        </a>
      </div>
    </div>

  </div>
</div>
</body>
</html>
