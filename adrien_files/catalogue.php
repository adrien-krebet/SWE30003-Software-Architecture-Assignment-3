<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8" />
 <meta name="description" content="SWE30003-Software Architectures and Design Assignment 3 " />
 <meta name="keywords" content="PHP" />
 <meta name="author" content="Adrien Krebet" />
 <title>Catalogue</title>
</head>
<body>
    <header>
        <h1>Assignment 3 Catalogue</h1>
        <a href="index.html">Home Page:</a>
        <a href="payment.html">Temp way to payment:</a>
        <a href="cavehorse.html">CAVEHORSECAVEHORSECAVEHORSE:</a>
        <a href="payment_class.php">payment_class:</a>
    </header>
    <?php
        //https://www.w3schools.com/php/php_oop_classes_objects.asp
        class Payment {
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
            function proccess_payment() {
                //Do some basic checks like card number length maybe
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
    ?>
</body>
</html>
