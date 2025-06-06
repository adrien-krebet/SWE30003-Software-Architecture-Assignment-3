<?php
require_once 'cart_class.php';
session_start();

// if no cart
if (!isset($_SESSION['cart']) || !($_SESSION['cart'] instanceof Cart)) {
    $_SESSION['cart'] = new Cart();
    $_SESSION['cart']->add_account_id(123); // placeholder ID
}

$cart = $_SESSION['cart'];

//remove item from session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_item_id'])) {
        $cart->remove_products($_POST['remove_item_id']);
    } elseif (isset($_POST['clear_cart'])) {
        $cart->remove_all_products();
    }
    $_SESSION['cart'] = $cart;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// html bit
$cart_list = $cart->get_products();
$cart->calculate_invoice($cart_list);
?>
<!DOCTYPE html>
<html>
    <nav>
        <a href="index.html">Home Page:</a>
        <a href="payment.html">Temp way to payment:</a>
        <!--<a href="cavehorse.html">CAVEHORSECAVEHORSECAVEHORSE:</a>
        <a href="payment_class.php">payment_class:</a>-->
        <a href="catalogue.php">Catalogue stuff:</a>
        <a href="view_cart.php">View Cart</a>
    </nav>
<h1>Assignment 3 Catalogue</h1>
<body>
<h1>Current Cart</h1>

<p><strong>Account ID:</strong> <?= htmlspecialchars($cart->get_account_id()) ?></p>
<?php if (count($cart_list) === 0): ?>
    <p>Your cart is empty :(.</p>
<?php else: ?>
    <?php foreach ($cart_list as $item): ?>
        <div style='border:1px solid #ccc; margin:10px; padding:10px'>
            <strong>Item ID:</strong> <?= htmlspecialchars($item->get_item_id()) ?><br>
            <strong>Name:</strong> <?= htmlspecialchars($item->get_item_name()) ?><br>
            <strong>Price:</strong> $<?= number_format($item->get_item_price(), 2) ?><br>
            <strong>Remaining Stock:</strong> <?= htmlspecialchars($item->get_item_remaining_quantity()) ?><br>
            <strong>Quantity in Cart:</strong> <?= htmlspecialchars($item->get_item_purchase_quantity()) ?><br>
            <form method="post" style="margin-top:5px">
                <input type="hidden" name="remove_item_id" value="<?= $item->get_item_id() ?>">
                <input type="submit" value="Remove Item">
            </form>
        </div>
    <?php endforeach; ?>
    <h2>Total: $<?= number_format($cart->get_invoice(), 2) ?></h2>
    <form method="post">
        <input type="hidden" name="clear_cart" value="1">
        <input type="submit" value="Clear Cart">
    </form>
<?php endif; ?>
</body>
</html>
