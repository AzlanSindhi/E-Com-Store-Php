<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FarmBasket - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-gray-100">

<?php include 'navbar.php'; ?>

<div class="container mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-6 text-green-700">Our Products</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <!-- Product 1 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <img src="../images/seed1.jpg" alt="Wheat Seeds" class="w-full h-48 object-cover">
            <div class="p-4">
                <h5 class="text-lg font-semibold mb-2">Wheat Seeds</h5>
                <p class="text-gray-600 mb-2">High quality wheat seeds for your farm.</p>
                <p class="text-green-600 font-bold mb-4">₹200</p>
                <a href="product.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">View</a>
            </div>
        </div>

        <!-- Product 2 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <img src="../images/pesticide1.jpg" alt="Pesticide" class="w-full h-48 object-cover">
            <div class="p-4">
                <h5 class="text-lg font-semibold mb-2">Organic Pesticide</h5>
                <p class="text-gray-600 mb-2">Safe pesticide to protect your crops.</p>
                <p class="text-green-600 font-bold mb-4">₹150</p>
                <a href="product.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">View</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
