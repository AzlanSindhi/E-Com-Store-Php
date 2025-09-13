<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_SESSION['admin'])) { header("Location: dashboard.php"); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $pass = $_POST['password'] ?? '';
  $stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1");
$stmt->execute([$email]);
$u = $stmt->fetch();
if ($u && $pass === $u['password']) {
    $_SESSION['admin'] = ['id'=>$u['id'], 'name'=>$u['name'], 'email'=>$u['email']];
    header("Location: dashboard.php"); exit;
} else {
    $error = "Invalid credentials.";
}

}
include __DIR__ . '/../includes/header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card p-4">
      <h3 class="mb-3">Admin Login</h3>
      <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
      <form method="post" class="row g-3">
        <div class="col-12">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-12">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="col-12 d-grid">
          <button class="btn btn-success">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
