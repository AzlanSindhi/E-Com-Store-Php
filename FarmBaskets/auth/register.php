<?php
require_once __DIR__ . "/../config.php";
$role = $_GET['role'] ?? 'customer';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $name = esc($_POST['name'] ?? '');
    $email = esc($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $role = esc($_POST['role'] ?? 'customer');
    if (!$name || !$email || !$pass) {
        flash('error','All fields are required.');
    } else {
       
                $approved = ($role==='supplier') ? 0 : 1;
                $sql = "INSERT INTO users (name,email,password,role,approved) VALUES ('$name','$email','$pass','$role',$approved)";

        if ($conn->query($sql)) {
            flash('info','Registration successful! Please login.' . ($role==='supplier' ? ' (Supplier approval pending)' : ''));
            header("Location: /FarmBaskets/auth/login.php?role=$role"); exit;
        } else {
            flash('error','Registration failed. Email may already exist.');
        }
    }
}
include __DIR__ . "/../partials/header.php";
?>
<div class="max-w-md mx-auto bg-white rounded-xl shadow p-6">
  <h2 class="text-2xl font-bold mb-4">Register (<?php echo htmlspecialchars($role); ?>)</h2>
  <form method="post">
    <input type="hidden" name="role" value="<?php echo htmlspecialchars($role); ?>"/>
    <label class="block mb-2 text-sm">Full Name</label>
    <input class="w-full border rounded p-2 mb-3" name="name" required/>
    <label class="block mb-2 text-sm">Email</label>
    <input class="w-full border rounded p-2 mb-3" name="email" type="email" required/>
    <label class="block mb-2 text-sm">Password</label>
    <input class="w-full border rounded p-2 mb-4" name="password" type="password" required/>
    <button class="w-full py-2 rounded bg-green-700 text-white hover:bg-green-800">Create Account</button>
  </form>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
