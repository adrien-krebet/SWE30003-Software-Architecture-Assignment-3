<!DOCTYPE html>
<html lang="en">
<body>
    <nav>
        <a href="index.html">Home Page:</a>
        <a href="payment.html">Temp way to payment:</a>
        <!--<a href="cavehorse.html">CAVEHORSECAVEHORSECAVEHORSE:</a>
        <a href="payment_class.php">payment_class:</a>-->
        <a href="catalogue.php">Catalogue stuff:</a>
        <a href="view_cart.php">View Cart</a>
        <a href="payment.php">payment:</a>
    </nav>
    <h1>Assignment 3 Catalogue</h1>
    <?php
        //echo "Catalogue page found!";

        // FIX THIS IT PRINTS STUFF OUT
        require_once 'cart_class.php'; // should items be a separate thing rather than two classes in one? idk
        require_once 'format.php';
        require_once 'catalogue_format.php'; 

        // I FORGOT TO MAKE CATALOGUE ITSELF A CLASS  :(((((

        class Statistics {
            // total purchased of each item
            private $totals = [];

            public function __construct($file = 'order_record.json') {
                if (!file_exists($file)) return;

                $data = json_decode(file_get_contents($file), true);
                if (!isset($data['orders'])) return;

                // for each order look in items and get the item name/quantity
                foreach ($data['orders'] as $order) {
                    foreach ($order['items'] as $item) {
                        $name = $item['name'];
                        $qty = intval($item['quantity']);
                        if (!isset($this->totals[$name])) {
                            $this->totals[$name] = 0;
                        }
                        $this->totals[$name] += $qty;
                    }
                }
            }
            public function get_item_purchases($item_name) {
                return $this->totals[$item_name] ?? 0;
            }
        }

        class Catalogue {
            private $products_list = [];

            public function __construct() {
                session_start();
                $this->load_products();
                $this->handle_post();
            }

            private function load_products() {
                // ty joel
                $json = file_get_contents('stock_record.JSON');
                // Check if the file was read successfully
                if ($json === false) {
                    die('Error reading the JSON file');
                }
                // Decode the JSON file
                $json_data = json_decode($json, true);

                // plop these bad boys into an array
                foreach ($json_data as $itemData) {
                    $item = new Item();
                    $item->add_item_id($itemData['id']);
                    $item->add_item_name($itemData['name']);
                    $item->add_item_remaining_quantity($itemData['remaining_quantity']);
                    $item->add_item_price($itemData['price']);
                    $item->add_item_purchase_quantity(0);
                    $item->add_item_long_desc($itemData['long_desc']);
                    $item->add_item_short_desc($itemData['short_desc']);
                    $item->add_item_catagory($itemData['catagory']); 
                    $this->products_list[] = $item;
                }
            }

            private function handle_post() {
                // put into cart request
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'], $_POST['quantity'])) {
                    // if the item id and quantity are in the request (clicking button), turns into bool int
                    $item_id = (int)$_POST['item_id'];
                    $quantity = (int)$_POST['quantity'];

                    // if no cart then create one (existing one for user or not)
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = new Cart();
                         echo "<p>made cart</p>";

                        $account_id = $_SESSION['account_id'] ?? 1;
                        $_SESSION['cart']->add_account_id($account_id);
                        //$_SESSION['cart']->add_account_id(1); // id = 1 for testing, actually retrieve account id in the session later
                    }
                    $_SESSION['cart']->add_products($item_id, $quantity, $this->products_list);
                    //$_SESSION['cart']->add_products($item_id, $quantity, $products_list);
                    echo "<p>Item added to cart.</p>";
                    // dunno know if this working as it should, fix up later
                }
            }

            public function render() {
                // CHECK ACCESS LEVEL THING FIX THIS UP
                $access = $_SESSION['access_level'] ?? 1;

                $format = new CatalogueFormat();
                #$format->setProducts($this->products_list);
                $format->setProducts($this->products_list, new Statistics());

                // different displays for access level, from format.php ty jord
                switch ($access) {
                    case 1:
                        //echo $format->adminLayout(); break;
                        echo $format->customerLayout(); break;
                    case 2:
                        echo $format->shipperLayout(); break;
                    case 3:
                        echo $format->adminLayout(); break;
                    default:
                        echo "<p>Not a valid access level.</p>";
                }
            }
        }
        $catalogue = new Catalogue();
        $catalogue->render();
    ?>
</body>
</html>
