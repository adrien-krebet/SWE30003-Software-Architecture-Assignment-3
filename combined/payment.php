<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8" />
 <meta name="description" content="SWE30003-Software Architectures and Design Assignment 3 " />
 <meta name="keywords" content="PHP" />
 <meta name="author" content="Joel Downie" />
 <title>Payment Menu Test PHP</title>
</head>

<body>
    <nav>

        <a href="index.html">Home Page:</a>
        <a href="payment.php">Temp way to payment:</a>
        <a href="cavehorse.html">CAVEHORSECAVEHORSECAVEHORSE:</a>
        <a href="catalogue.php">Catalogue stuff:</a>
        <a href="payment.php">payment:</a>
    </nav>
    <h1>Assignment 3 Payment proccesing</h1>
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        include 'order.php';
        include 'cart_class.php';//gets the cart file and sequency check
        require_once 'sequence_check.php';
        session_start();

        $cart = $_SESSION['cart'];

        $invoice = $cart->get_invoice();//NEEEEEDS FIXING
        echo "<h1>Payment Page</h1>";
        echo "<p>Please give us $$invoice of your money.</p>";
    ?>
        <section class="background_sheet">
        <form action="payment.php" method="post">
            <fieldset>
                <legend>Payment Details</legend>
                <p>Card number:</p>
                <input type="text" name="card" id="card" required />

                <p>Card expiry date:</p>
                <input type="text" name="expiery_date" id="expiery_date" required />

                <p>CSV:</p>
                <input type="text" name="CSV" id="CSV" required />

                <p>Collection method:</p>
                <input type="radio" id="c1" name="collection_method" value="in_store_collection" required>
                <label for="c1">In-store Pickup</label>
                <input type="radio" id="c2" name="collection_method" value="delivery">
                <label for="c2">Delivery</label>

                <p>Address:</p>
                <input type="text" name="address" id="address" />

                <p>Postcode:</p>
                <input type="text" name="postcode" id="postcode" />

                <p>
                    <input type="submit" value="Submit payment" />
                    <input type="reset" value="Clear" />
                </p>
            </fieldset>
        </form>
    </section>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["card"])) {

        class Payment extends Sequence_check {
            public $card_number, $card_expiry, $CSV, $collection_method, $contact_details, $address, $postcode;

            function set_card_number($n) { $this->card_number = $n; }
            function set_card_expiry($e) { $this->card_expiry = $e; }
            function set_CSV($c) { $this->CSV = $c; }
            function set_collection_method($m) { $this->collection_method = $m; }
            function set_contact_details($d) { $this->contact_details = $d; }
            function set_address($a) { $this->address = $a; }
            function set_postcode($p) { $this->postcode = $p; }

            function get_card_number() { return $this->card_number; }
            function get_card_expiry() { return $this->card_expiry; }
            function get_CSV() { return $this->CSV; }
            function get_collection_method() { return $this->collection_method; }
            function get_contact_details() { return $this->contact_details; }
            function get_address() { return $this->address; }
            function get_postcode() { return $this->postcode; }

            public function verify_data($data_input) {
                if (strlen($this->card_number) < 15 || strlen($this->card_number) > 16) {
                    return "Card number must be 15-16 digits.";
                }
                return "";
            }
        }

        $payment = new Payment();
        $payment->set_card_number($_POST["card"]);
        $payment->set_card_expiry($_POST["expiery_date"]);
        $payment->set_CSV($_POST["CSV"]);
        $payment->set_contact_details("Adrien@fountaingate.hotmail");
        $payment->set_collection_method($_POST["collection_method"]);
        $payment->set_address($_POST["address"]);
        $payment->set_postcode($_POST["postcode"]);

        $error = $payment->verify_data(null);

        if ($error === "") {
            /*echo "<h2>Payment Details Received</h2>";
            echo "Card Number: " . $payment->get_card_number() . "<br>";
            echo "Expiry: " . $payment->get_card_expiry() . "<br>";
            echo "CSV: " . $payment->get_CSV() . "<br>";
            echo "Collection: " . $payment->get_collection_method() . "<br>";
            echo "Address: " . $payment->get_address() . "<br>";
            echo "Postcode: " . $payment->get_postcode() . "<br>";*/

            // UNCOMMENT ABOVE IF NEEDED

            $order = new Order();
            $account = $cart->get_account_id();
            $collection_method = $payment->get_collection_method();
            if ($collection_method == "delivery") {
                $shipping_address = $payment->get_address();
                $postcode = $payment->get_postcode();
            }
            else {
                $shipping_address = "NA";
                $postcode = "NA";
            }
            $contact = $payment->get_contact_details();

            // im not sure whether we wanna use the collection method to determine whether we ask for address or not but eh outside of scope maybe

            // fixed typo :)
            $order_proccess_check = $order->verify_data(true);
            if ($order_proccess_check === "") {
                $order->set_order_account_id($account);
                $order->set_order_items($cart);
                $order->set_order_collection_method($collection_method);
                $order->set_order_contact_details($contact);
                $order->set_order_address($shipping_address);
                $order->set_order_postcode($postcode);

                echo "<h2>Order Summary</h2>";
                echo "Account ID: $account<br>";
                echo "Collection Method: $collection_method<br>";
                echo "Address: $shipping_address<br>";
                echo "Postcode: $postcode<br>";

                echo "<h2>Placing Order...</h2>";
                $order->create_order();

                // clear cart once processed
                unset($_SESSION['cart']);
                // idk if we wanna mess with the stock record
            } else {
                echo "<p>$order_proccess_check</p>";
            }
        } else {
            echo "<p>Error: $error</p>";
        }
    }
    ?>
</body>
</html>
