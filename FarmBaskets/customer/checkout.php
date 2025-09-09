<?php
require_once __DIR__ . "/../partials/header.php";
require_login();
$cart = $_SESSION['cart'] ?? [];
if (!$cart) { flash('error','Cart is empty.'); header("Location: products.php"); exit; }

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $conn->begin_transaction();
    try {
        $cid = intval($_SESSION['user']['id']);
        $total = 0.0;
        foreach($cart as $pid=>$qty) {
            $r = $conn->query("SELECT price,stock FROM products WHERE id=$pid FOR UPDATE");
            $row = $r->fetch_assoc();
            if ($row['stock'] < $qty) throw new Exception("Insufficient stock for product #$pid");
            $total += $row['price'] * $qty;
        }
        $conn->query("INSERT INTO orders (customer_id,total_amount,status) VALUES ($cid,$total,'paid')");
        $oid = $conn->insert_id;
        foreach($cart as $pid=>$qty) {
            $r = $conn->query("SELECT price FROM products WHERE id=$pid");
            $price = $r->fetch_assoc()['price'];
            $conn->query("INSERT INTO order_items (order_id,product_id,quantity,unit_price) VALUES ($oid,$pid,$qty,$price)");
            $conn->query("UPDATE products SET stock = stock - $qty WHERE id=$pid");
        }
        $conn->commit();
        $_SESSION['cart'] = [];
        flash('info',"Order #$oid placed successfully!");
        header("Location: orders.php"); exit;
    } catch (Exception $e) {
        $conn->rollback();
        flash('error',"Checkout failed: " . $e->getMessage());
    }
}
?>
<h2 class="text-2xl font-bold mb-4">Checkout</h2>
<div class="bg-white rounded-xl shadow p-6">
  <p class="mb-4">This is a demo checkout. Click Pay to place order.</p>
  <form method="post">
    <button class="px-4 py-2 rounded bg-green-700 text-white hover:bg-green-800">Pay & Place Order</button>
  </form>
</div>
<?php include __DIR__ . "/../partials/footer.php"; ?>
