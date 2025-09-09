<?php
require_once __DIR__ . "/../partials/header.php";
require_role('admin');
$res = $conn->query("SELECT id,name,email,role,approved,created_at FROM users ORDER BY id DESC");
?>
<h2 class="text-2xl font-bold mb-4">All Users</h2>
<div class="bg-white rounded-xl shadow overflow-hidden">
<table class="w-full text-sm">
  <thead class="bg-slate-100"><tr><th class="text-left p-2">Name</th><th>Email</th><th>Role</th><th>Approved</th><th>Joined</th></tr></thead>
  <tbody>
  <?php while($u=$res->fetch_assoc()): ?>
    <tr class="border-t">
      <td class="p-2"><?php echo htmlspecialchars($u['name']);?></td>
      <td class="text-center"><?php echo htmlspecialchars($u['email']);?></td>
      <td class="text-center"><?php echo htmlspecialchars($u['role']);?></td>
      <td class="text-center"><?php echo $u['role']==='supplier' ? ($u['approved']?'Yes':'No') : '-';?></td>
      <td class="text-center"><?php echo $u['created_at']; ?></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
