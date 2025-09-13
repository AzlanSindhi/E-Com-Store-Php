<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
include __DIR__ . '/includes/header.php';

// fetch categories & products
$cats = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();
$cat_id = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$sql = "SELECT p.*, c.name AS category_name FROM products p
        JOIN categories c ON c.id = p.category_id
        WHERE p.is_active = 1";
$params = [];
if ($cat_id) { $sql .= " AND p.category_id = :cat"; $params[':cat'] = $cat_id; }
if ($search !== '') { $sql .= " AND (p.name LIKE :q OR p.description LIKE :q)"; $params[':q'] = "%$search%"; }
$sql .= " ORDER BY p.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>
<section class="hero mb-4">
  <div class="text-center p-5">
    <h1 class="display-5 fw-bold">Seeds & Pesticides, delivered.</h1>
    <p class="lead">Quality inputs for every farm — buy trusted brands at fair prices.</p>
    <form class="row g-2 justify-content-center mt-3">
      <div class="col-md-4">
        <input type="text" class="form-control" name="q" placeholder="Search seeds, pesticides..." value="<?= htmlspecialchars($search) ?>">
      </div>
      <div class="col-md-3">
        <select class="form-select" name="cat">
          <option value="0">All categories</option>
          <?php foreach ($cats as $c): ?>
          <option value="<?= $c['id'] ?>" <?= $cat_id==$c['id']?'selected':'' ?>><?= htmlspecialchars($c['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2 d-grid">
        <button class="btn btn-success">Search</button>
      </div>
    </form>
  </div>
</section>

<h2 class="mb-3">Products</h2>
<?php if (!$products): ?>
<div class="alert alert-warning">No products found.</div>
<?php endif; ?>

<div class="row g-4">
<?php foreach ($products as $p): ?>
  <div class="col-12 col-sm-6 col-lg-4">
    <div class="card card-product h-100">
      <img src="<?= htmlspecialchars($p['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>" style="height:220px;object-fit:cover;">
      <div class="card-body d-flex flex-column">
        <span class="badge badge-soft mb-2"><?= htmlspecialchars($p['category_name']) ?></span>
        <h5 class="card-title"><?= htmlspecialchars($p['name']) ?></h5>
        <p class="card-text text-muted small flex-grow-1"><?= htmlspecialchars($p['short_description']) ?></p>
        <div class="d-flex justify-content-between align-items-center">
          <div class="price fs-5">₹<?= number_format($p['price'], 2) ?></div>
          <a href="product.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-success">View</a>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
