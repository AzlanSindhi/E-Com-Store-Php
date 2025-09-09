<?php
require_once __DIR__ . "/../partials/header.php";
require_role('admin');
if (isset($_GET['approve'])) {
    $sid = intval($_GET['approve']);
    $conn->query("UPDATE users SET approved=1 WHERE id=$sid AND role='supplier'");
    header("Location: suppliers.php"); exit;
}
if (isset($_GET['reject'])) {
    $sid = intval($_GET['reject']);
    $conn->query("UPDATE users SET approved=0 WHERE id=$sid AND role='supplier'");
    header("Location: suppliers.php"); exit;
}
$res = $conn->query("SELECT id,name,email,approved FROM users WHERE role='supplier' ORDER BY id DESC");
?>
<h2 class="text-2xl font-bold mb-4">Suppliers</h2>
<div class="bg-white rounded-xl shadow overflow-hidden">
<table class="w-full text-sm">
  <thead class="bg-slate-100"><tr><th class="text-left p-2">Name</th><th>Email</th><th>Status</th><th>Action</th></tr></thead>
  <tbody>
  <?php while($s=$res->fetch_assoc()): ?>
    <tr class="border-t">
      <td class="p-2"><?php echo htmlspecialchars($s['name']);?></td>
      <td class="text-center"><?php echo htmlspecialchars($s['email']);?></td>
      <td class="text-center"><?php echo $s['approved']?'Approved':'Pending';?></td>
      <td class="text-center">
        <?php if (!$s['approved']): ?>
          <a class="text-green-700 hover:underline" href="?approve=<?php echo $s['id'];?>">Approve</a>
        <?php else: ?>
          <a class="text-red-700 hover:underline" href="?reject=<?php echo $s['id'];?>">Revoke</a>
        <?php endif; ?>
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
