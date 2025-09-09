<?php
require_once __DIR__ . "/../config.php";
$role = $_GET['role'] ?? 'customer';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $email = esc($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $role = esc($_POST['role'] ?? 'customer');
    $q = $conn->query("SELECT * FROM users WHERE email='$email' AND role='$role' LIMIT 1");
    if ($q && $q->num_rows === 1) {
        $u = $q->fetch_assoc();

        if ($pass === $u['password']) {
            if ($u['role']==='supplier' && intval($u['approved'])!==1) {
                flash('error', 'Supplier account pending approval by admin.');
            } else {
                $_SESSION['user'] = ['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email'],'role'=>$u['role']];
                flash('info', 'Welcome back, '.$u['name'].'!');
                $dest = '/FarmBaskets/index.php';
                if ($u['role']==='admin') $dest = '/FarmBaskets/admin/dashboard.php';
                if ($u['role']==='supplier') $dest = '/FarmBaskets/supplier/dashboard.php';
                header("Location: $dest"); exit;
            }
        } else {
            flash('error', 'Invalid credentials.');
        }

    } else {
        flash('error', 'Account not found.');
    }
}
include __DIR__ . "/../partials/header.php";
?>
<div class="max-w-md mx-auto bg-white rounded-xl shadow p-6">
  <h2 class="text-2xl font-bold mb-4">Login (<?php echo htmlspecialchars($role); ?>)</h2>
  <form method="post">
    <input type="hidden" name="role" value="<?php echo htmlspecialchars($role); ?>"/>
    <label class="block mb-2 text-sm">Email</label>
    <input class="w-full border rounded p-2 mb-3" name="email" type="email" required/>
    <label class="block mb-2 text-sm">Password</label>
    <input class="w-full border rounded p-2 mb-4" name="password" type="password" required/>
    <button class="w-full py-2 rounded bg-green-700 text-white hover:bg-green-800">Login</button>
    <p class="mt-3 text-sm">No account? <a class="text-green-700 hover:underline" href="/FarmBaskets/auth/register.php?role=<?php echo htmlspecialchars($role); ?>">Register</a></p>
  </form>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
