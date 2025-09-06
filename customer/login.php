<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>FarmBasket - Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F9F6F1] font-sans">

  <?php include 'navbar.php'; ?>

  <div class="flex items-center justify-center mt-40">
    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8 border border-[#D2B48C]">
      <h2 class="text-2xl font-bold text-center text-[#5C4033] mb-6">Login</h2>
      
      <form>
        <div class="mb-4">
          <label class="block text-[#5C4033] font-medium mb-1">Email</label>
          <input type="email" required
            class="w-full px-4 py-2 border border-[#D2B48C] rounded-lg focus:ring-2 focus:ring-[#D2B48C] focus:outline-none">
        </div>

        <div class="mb-4">
          <label class="block text-[#5C4033] font-medium mb-1">Password</label>
          <input type="password" required
            class="w-full px-4 py-2 border border-[#D2B48C] rounded-lg focus:ring-2 focus:ring-[#D2B48C] focus:outline-none">
        </div>

        <button type="submit"
          class="w-full bg-[#D2B48C] hover:bg-[#c4a070] text-white font-semibold py-2 rounded-lg transition duration-300">
          Login
        </button>
      </form>
    </div>
  </div>

</body>
</html>
