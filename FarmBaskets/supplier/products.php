<?php
require_once __DIR__ . "/../partials/header.php";
require_role('supplier');
$sid = intval($_SESSION['user']['id']);

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $id = intval($_POST['id'] ?? 0);
    $name = esc($_POST['name'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $img = esc($_POST['image_url'] ?? '');
    $desc = esc($_POST['description'] ?? '');
    if ($id>0) {
        $conn->query("UPDATE products SET name='$name',price=$price,stock=$stock,image_url='$img',description='$desc' WHERE id=$id AND supplier_id=$sid");
        flash('info','Product updated.'); header("Location: products.php"); exit;
    } else {
        $conn->query("INSERT INTO products (supplier_id,name,description,price,stock,image_url,is_active) VALUES ($sid,'$name','$desc',$price,$stock,'$img',1)");
        flash('info','Product added.'); header("Location: products.php"); exit;
    }
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id=$id AND supplier_id=$sid");
    header("Location: products.php"); exit;
}

$mine = $conn->query("SELECT * FROM products WHERE supplier_id=$sid ORDER BY id DESC");
?>
<h2 class="text-2xl font-bold mb-4">My Products</h2>
<div class="grid md:grid-cols-2 gap-6">
  <div class="bg-white rounded-xl shadow p-4">
    <h3 class="font-semibold mb-2">Add / Edit Product</h3>
    <form method="post" class="space-y-2">
      <input type="hidden" name="id" value="<?php echo intval($_GET['edit'] ?? 0);?>"/>
      <input class="w-full border rounded p-2" name="name" placeholder="Name" required/>
      <textarea class="w-full border rounded p-2" name="description" placeholder="Description"></textarea>
      <input class="w-full border rounded p-2" name="price" type="number" step="0.01" placeholder="Price" required/>
      <input class="w-full border rounded p-2" name="stock" type="number" placeholder="Stock" required/>
      <input class="w-full border rounded p-2" name="image_url" placeholder="Image URL" value="https://images.unsplash.com/photo-1542831371-29b0f74f9713?w=800&q=80"/>
      <button class="px-3 py-2 rounded bg-green-700 text-white">Save</button>
    </form>
  </div>
  <div class="bg-white rounded-xl shadow p-4">
    <h3 class="font-semibold mb-2">Your Items</h3>
    <table class="w-full text-sm">
      <thead class="bg-slate-100"><tr><th class="text-left p-2">Name</th><th>Price</th><th>Stock</th><th></th></tr></thead>
      <tbody>
        <?php while($p=$mine->fetch_assoc()): ?>
        <tr class="border-t">
          <td class="p-2"><?php echo htmlspecialchars($p['name']);?></td>
          <td class="text-center">₹<?php echo number_format($p['price'],2);?></td>
          <td class="text-center"><?php echo intval($p['stock']);?></td>
          <td class="text-center">
            <a class="text-blue-600 hover:underline" href="?edit=<?php echo $p['id'];?>">Edit</a> • 
            <a class="text-red-600 hover:underline" href="?delete=<?php echo $p['id'];?>">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
