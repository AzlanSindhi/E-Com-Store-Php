<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle remove item
if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit;
}

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['qty'] as $id => $qty) {
        if ($qty > 0) {
            $_SESSION['cart'][$id]['quantity'] = intval($qty);
        } else {
            unset($_SESSION['cart'][$id]);
        }
    }
    header("Location: cart.php");
    exit;
}

$cart = $_SESSION['cart'];
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Cart - Farm'sBasket</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen font-sans">

<header class="bg-white shadow p-4">
  <div class="max-w-6xl mx-auto flex justify-between items-center">
    <h1 class="text-xl font-bold text-green-700">Farm'sBasket</h1>
    <nav class="space-x-4">
      <a href="index.php" class="hover:text-green-600">Shop</a>
      <a href="orders.php" class="hover:text-green-600">My Orders</a>
      <a href="logout.php" class="text-red-600 hover:text-red-800">Logout</a>
    </nav>
  </div>
</header>

<main class="max-w-6xl mx-auto px-4 py-8">
  <h2 class="text-2xl font-bold mb-6">My Cart</h2>

  <?php if (empty($cart)): ?>
    <p class="text-gray-600">🛒 Your cart is empty. <a href="index.php" class="text-green-600 font-semibold">Shop now</a>.</p>
  <?php else: ?>
    <form method="post">
      <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full border-collapse">
          <thead class="bg-green-100">
            <tr>
              <th class="p-3 text-left">Product</th>
              <th class="p-3 text-center">Price</th>
              <th class="p-3 text-center">Quantity</th>
              <th class="p-3 text-center">Subtotal</th>
              <th class="p-3 text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cart as $id => $item): 
              $subtotal = $item['price'] * $item['quantity'];
              $total += $subtotal;
            ?>
            <tr class="border-t">
              <td class="p-3"><?php echo htmlspecialchars($item['name']); ?></td>
              <td class="p-3 text-center">₹<?php echo number_format($item['price'], 2); ?></td>
              <td class="p-3 text-center">
                <input type="number" name="qty[<?php echo $id; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="w-16 border rounded px-2 py-1 text-center">
              </td>
              <td class="p-3 text-center">₹<?php echo number_format($subtotal, 2); ?></td>
              <td class="p-3 text-center">
                <a href="cart.php?remove=<?php echo $id; ?>" class="text-red-600 hover:text-red-800">Remove</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="mt-6 flex justify-between items-center">
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Update Cart</button>
        <div class="text-xl font-semibold">Total: ₹<?php echo number_format($total, 2); ?></div>
      </div>
    </form>

    <div class="mt-6 text-right">
      <a href="checkout.php" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">Proceed to Checkout</a>
    </div>
  <?php endif; ?>
</main>

</body>
</html>
