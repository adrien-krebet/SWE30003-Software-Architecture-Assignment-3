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
    <header>
        <h1>Assignment 3 Payment proccesing</h1>
        <a href="index.html">Home Page:</a>
        <a href="payment.php">Temp way to payment:</a>
        <a href="cavehorse.html">CAVEHORSECAVEHORSECAVEHORSE:</a>
        <a href="payment_class.php">payment_class:</a>
    </header>
    <?php
        include 'cart_class.php';//gets the cart file and sequency check
        $invoice = $cart->get_invoice();
        echo "<h1>Payment Page</h1>";
        echo "<p>Please give us $$invoice of your money.</p>";
    ?>
        <section class="background_sheet">
        <form action = "payment.php" method = "post" >
            <fieldset>
                <legend>Payment field:</legend>
                <p>Card number:</p>
                <p>
                    <input type="text" name= "card" id="card"/>
                </p>
                <p>Card expiery date:</p>
                <p>
                    <input type="text" name= "expiery_date" id="expiery_date"/>
                </p>
                <p>CSV:</p>
                <p>
                    <input type="text" name= "CSV" id="CSV"/>
                </p>
                <p>Collection method</p>
                <p>
                    <input type="radio" id="c1" name="collection_method" value="in_store_collection"> <label for="c1">In store pickup</label>
                    <input type="radio" id="c2" name="collection_method" value="delivery"> <label for="c2">Delivery</label>
                </p>
                <p>Your address:</p>
                <p>
                    <input type="text" name= "address" id="address"/>
                </p>
                <p>Your postcode:</p>
                <p>
                    <input type="text" name= "postcode" id="postcode"/>
                </p>
                <p>
                    <input id="submit" class="inputButtons" type= "submit" value="Submit payment"/> <input class="inputButtons" type= "reset" value="Clear"/>
                </p>
            </fieldset>
        </form>
    </section>
    <?php
        if ($_POST["card"] != "") {
        //https://www.w3schools.com/php/php_oop_classes_objects.asp
        //https://www.geeksforgeeks.org/php/php-strlen-function/
        class Payment extends Sequence_check {
            // Properties
            public $card_number;
            public $card_expiry;
            public $CSV;
            public $collection_method;
            public $contact_details;
            public $address;
            public $postcode;

            // Methods
            function set_card_number($card_number) {
                $this->card_number = $card_number;
            }
            function set_card_expiry($card_expiry) {
                $this->card_expiry = $card_expiry;
            }
            function set_CSV($CSV) {
                $this->CSV = $CSV;
            }
            function set_collection_method($collection_method) {
                $this->collection_method = $collection_method;
            }
            function set_contact_details($contact_details) {
                $this->contact_details = $contact_details;
            }
            function set_address($address) {
                $this->address = $address;
            }
            function set_postcode($postcode) {
                $this->postcode = $postcode;
            }
            //Just for testing will remove later as these individual values do not need returns
            function get_card_number() {
                return $this->card_number;
            }
            function get_card_expiry() {
                return $this->card_expiry;
            }
            function get_CSV() {
                return $this->CSV;
            }
            function get_collection_method() {
                return $this->collection_method;
            }
            function get_contact_details() {
                return $this->contact_details;
            }
            function get_address() {
                return $this->address;
            }
            function get_postcode() {
                return $this->postcode;
            }
            function veryify_data($payment) {//add error checks/messages here
                $error_message = "";
                $card_number = $payment->get_card_number();
                if (strlen($card_number) < 15 or strlen($card_number) > 16) {//google says this is the australian card length
                    $error_message = "Your card number is not 15-16 digets long";
                }
                $this->error_message = $error_message;
                return $error_message;
            }
        }
        echo "<h1>PHP test form and class display.</h1>";
        $payment = new Payment();
        $payment->set_card_number($_POST["card"]);
        $payment->set_card_expiry($_POST["expiery_date"]);
        $payment->set_CSV($_POST["CSV"]);
        $payment->set_contact_details("Adrien@fountaingate.hotmail");//DO NOTE THIS HAS CHANGED FROM ASSIGNMENT 1. For now its hard coded but will be obtained through acount.
        $payment->set_collection_method($_POST["collection_method"]);
        $payment->set_address($_POST["address"]);
        $payment->set_postcode($_POST["postcode"]);

        $verification_check = $payment->veryify_data($payment);
        if ($verification_check == "") {//if passed it will pass along the blank value to the next check in order
            echo "Card number: " . $payment->get_card_number();
            echo "<br>";
            echo "Card expiery: " .  $payment->get_card_expiry();
            echo "<br>";
            echo "CSV: " . $payment->get_CSV();
            echo "<br>";
            echo "Contact Details: " . $payment->get_contact_details();
            echo "<br>";
            echo "Collection method: " . $payment->get_collection_method();
            echo "<br>";
            echo "Address: " . $payment->get_address();
            echo "<br>";
            echo "Postcode: " . $payment->get_postcode();

            echo "<h1>Order time</h1>";
            include 'order.php';
            $account = $cart->get_acount_id();
            $payment_status = true;//used to simulate if the payment has gone through or not
            $collection_method = $payment->get_collection_method();
            $contact_details = $payment->get_contact_details();
            if ($collection_method == "delivery") {
                $shipping_address = $payment->get_address();
                $postcode = $payment->get_postcode();
            }
            else {
                $shipping_address = "NA";
                $postcode = "NA";
            }

            $order = new Order();
            //check payment success
            $verification_check = $order->veryify_data($payment_status);
            if ($verification_check == "") {
                $order->set_order_account_id($account);//will be from the acount session i asume for now hard coded
                $order->set_order_items($cart);
                $order->set_order_collection_method($collection_method);
                $order->set_order_contact_details($contact_details);//will be from the acount session i asume for now hard coded
                $order->set_order_address($shipping_address);
                $order->set_order_postcode($postcode);
                //temp display for testing
                echo "Order acount ID: " . $order->get_order_account_id();
                echo "<br>";
                var_dump($order->get_order_items());
                echo "<br>";
                echo "Order collection method: " . $order->get_order_collection_method();
                echo "<br>";
                echo "Order Contact details: " . $order->get_order_contact_details();
                echo "<br>";
                echo "Order address: " . $order->get_order_address();
                echo "<br>";
                echo "Order postcode: " . $order->get_order_postcode();
                echo "<br>";

                echo "<h1>Final confirmation</h1>";
                $order->create_order($order);
            }
            else {
                echo "<p>Verification status: " . $verification_check . "</p>";
                echo "<br>";
            }
        }
        else {
            echo "<p>Verification status: " . $verification_check . "</p>";
            echo "<br>";
        }
    }
    else {
        echo "<br>";
    }
    ?>
</body>
</html>
