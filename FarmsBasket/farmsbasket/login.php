<?php
//manage login if else keep only customer and manage password checking 

session_start();

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'farmsbasket';
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = trim($_POST['password'] ?? '');
if ($email && $password) {
    $sql = "SELECT u.id, u.name, u.email, u.password, u.role_id, u.status, r.name AS role
            FROM users u 
            JOIN roles r ON r.id = u.role_id
            WHERE u.email=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    // set sessions properly
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['role'] = $row['role']; // important


    if ($row['role'] === 'admin') {
        header("Location: admin/dashboard.php");
    } elseif ($row['role'] === 'supplier') {
        header("Location: supplier/dashboard.php");
    } else {
        header("Location: customer/dashboard.php");
    }
    exit;
}
 else {
            $error = "❌ Wrong password or inactive account.";
        }
    } else {
        $error = "❌ Email not found.";
    }
}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login — Farm'sBasket</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-green-100">
  <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
    <h1 class="text-2xl font-bold text-green-700 mb-4 text-center">Farm'sBasket Login</h1>
    <?php if ($error): ?>
      <div class="mb-4 p-3 rounded bg-red-100 text-red-700"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" class="space-y-4">
      <div>
        <label class="block text-sm mb-1">Email</label>
        <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400">
      </div>
      <div>
        <label class="block text-sm mb-1">Password</label>
        <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-400">
      </div>
      <button class="w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Login</button>
    </form>
    <p class="mt-4 text-sm text-center">Don't have an account? <a href="register.php" class="text-green-700 font-semibold">Register</a></p>
  </div>
</body>
</html>
