<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin'])) { header("Location: index.php"); exit; }

// Create/Update product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  $name = trim($_POST['name']);
  $short = trim($_POST['short_description']);
  $desc = trim($_POST['description']);
  $price = (float)$_POST['price'];
  $category_id = (int)$_POST['category_id'];
  $img = trim($_POST['image_url']);
  $active = isset($_POST['is_active']) ? 1 : 0;

  if ($id) {
    $stmt = $pdo->prepare("UPDATE products SET name=?, short_description=?, description=?, price=?, category_id=?, image_url=?, is_active=? WHERE id=?");
    $stmt->execute([$name,$short,$desc,$price,$category_id,$img,$active,$id]);
  } else {
    $stmt = $pdo->prepare("INSERT INTO products (name, short_description, description, price, category_id, image_url, is_active) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([$name,$short,$desc,$price,$category_id,$img,$active]);
  }
  header("Location: products.php"); exit;
}

// Delete product
if (isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $pdo->prepare("DELETE FROM products WHERE id=?")->execute([$id]);
  header("Location: products.php"); exit;
}

$cats = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$items = $pdo->query("SELECT p.*, c.name AS category FROM products p JOIN categories c ON c.id=p.category_id ORDER BY p.created_at DESC")->fetchAll();

include __DIR__ . '/../includes/header.php';
?>
<h2>Manage Products</h2>

<div class="row g-3">
  <div class="col-lg-6">
    <div class="card p-3">
      <h5 class="mb-2">Add / Edit Product</h5>
      <form method="post" class="row g-2">
        <input type="hidden" name="id" id="id">
        <div class="col-12"><input required class="form-control" name="name" placeholder="Name"></div>
        <div class="col-12"><input class="form-control" name="short_description" placeholder="Short description"></div>
        <div class="col-12"><textarea class="form-control" name="description" rows="3" placeholder="Full description"></textarea></div>
        <div class="col-6"><input type="number" step="0.01" min="0" class="form-control" name="price" placeholder="Price"></div>
        <div class="col-6">
          <select class="form-select" name="category_id">
            <?php foreach ($cats as $c): ?>
              <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-12"><input class="form-control" name="image_url" placeholder="Image URL"></div>
        <div class="col-12 form-check ms-2">
          <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
          <label class="form-check-label" for="is_active">Active</label>
        </div>
        <div class="col-12 d-grid"><button class="btn btn-success">Save Product</button></div>
      </form>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card p-3">
      <h5 class="mb-2">Products</h5>
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle">
          <thead><tr><th>Name</th><th>Category</th><th>Price</th><th>Active</th><th width="130">Actions</th></tr></thead>
          <tbody>
            <?php foreach ($items as $it): ?>
              <tr>
                <td><?= htmlspecialchars($it['name']) ?></td>
                <td><?= htmlspecialchars($it['category']) ?></td>
                <td>₹<?= number_format($it['price'],2) ?></td>
                <td><?= $it['is_active'] ? 'Yes' : 'No' ?></td>
                <td>
                  <a class="btn btn-sm btn-outline-primary" href="#" onclick='fillForm(<?= json_encode($it) ?>)'>Edit</a>
                  <a class="btn btn-sm btn-outline-danger" href="?delete=<?= $it['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
function fillForm(p){
  for (const [k,v] of Object.entries(p)) {
    const el = document.querySelector(`[name="${k}"]`);
    if (!el) continue;
    if (el.type === 'checkbox') el.checked = !!Number(v);
    else el.value = v;
  }
  document.getElementById('id').value = p.id;
}
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
