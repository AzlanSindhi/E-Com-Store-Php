<?php
// admin/admin_login.php — Admin-only login page
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
    $sql = "SELECT u.id, u.name, u.email, u.password, r.name AS role
            FROM users u 
            JOIN roles r ON r.id = u.role_id
            WHERE u.email=? AND u.password=? AND u.status='active' AND r.name='admin' LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
      $_SESSION['user'] = $row;
      header("Location: dashboard.php");
      exit;
    } else {
      $error = "Invalid admin credentials.";
    }
  } else {
    $error = "Please enter both email and password.";
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login — Farm'sBasket</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
  <div class="bg-white shadow-xl rounded-xl p-8 w-full max-w-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">Admin Login</h1>
    <?php if ($error): ?>
      <div class="mb-4 p-3 rounded bg-red-100 text-red-700"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" class="space-y-4">
      <div>
        <label class="block text-sm mb-1">Email</label>
        <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-gray-500">
      </div>
      <div>
        <label class="block text-sm mb-1">Password</label>
        <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-gray-500">
      </div>
      <button class="w-full py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">Login</button>
    </form>
  </div>
</body>
</html>
