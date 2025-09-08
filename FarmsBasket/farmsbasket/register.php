<?php
// register.php
require_once __DIR__ . "/config.php";

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = 'customer'; // default role for registration

    if ($name && $email && $password) {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id) 
                                VALUES (?, ?, ?, (SELECT id FROM roles WHERE name=?))");
        $stmt->bind_param("ssss", $name, $email, $password, $role);

        if ($stmt->execute()) {
            $message = "<span class='text-green-700'>✅ Registration successful! You can now <a href='login.php' class='underline'>login</a>.</span>";
        } else {
            if ($conn->errno == 1062) { // duplicate email
                $message = "<span class='text-red-700'>⚠️ This email is already registered. Please use another.</span>";
            } else {
                $message = "<span class='text-red-700'>❌ Error: " . htmlspecialchars($stmt->error) . "</span>";
            }
        }
        $stmt->close();
    } else {
        $message = "<span class='text-red-700'>⚠️ Please fill all fields.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Farm'sBasket</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 font-sans">
  <div class="flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
      <h2 class="text-2xl font-bold text-green-700 mb-6 text-center">Create an Account</h2>

      <?php if ($message): ?>
        <div class="mb-4 p-3 text-sm bg-green-100 rounded">
          <?= $message ?>
        </div>
      <?php endif; ?>

      <form method="post" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Full Name</label>
          <input type="text" name="name" required class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" required class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" name="password" required class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-green-500 focus:border-green-500">
        </div>

        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Register</button>
      </form>

      <p class="text-sm text-gray-600 mt-4 text-center">
        Already have an account? <a href="login.php" class="text-green-600 font-semibold">Login here</a>
      </p>
    </div>
  </div>
</body>
</html>
