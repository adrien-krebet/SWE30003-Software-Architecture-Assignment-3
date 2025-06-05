<!DOCTYPE html>
<html>
<body>
    <h1>Cart test</h1>
    <?php
        //https://www.w3schools.com/php/php_oop_classes_objects.asp
        //https://www.w3schools.com/js/js_json_datatypes.asp
        //https://www.geeksforgeeks.org/php/how-to-parse-a-json-file-in-php/
        //https://www.w3schools.com/php/php_json.asp
        //https://stackoverflow.com/questions/42233076/get-specific-object-from-specific-id-json
        include 'sequence_check.php';
        class Item {
            // Properties
            public $item_id;
            public $item_name;
            public $item_remaining_quantity;
            public $item_purchase_quantity;
            public $item_price;
            public $item_long_desc;
            public $item_short_desc;
            public $item_catagory;

            // Methods
            function add_item_id($item_id) {
                $this->item_id = $item_id;
            }
            function add_item_name($item_name) {
                $this->item_name = $item_name;
            }
            function add_item_remaining_quantity($item_remaining_quantity) {
                $this->item_remaining_quantity = $item_remaining_quantity;
            }
            function add_item_purchase_quantity($item_purchase_quantity) {
                $this->item_purchase_quantity = $item_purchase_quantity;
            }
            function add_item_price($item_price) {
                $this->item_price = $item_price;
            }
            function add_item_long_desc($item_long_desc) {
                $this->item_long_desc = $item_long_desc;
            }
            function add_item_short_desc($item_short_desc) {
                $this->item_short_desc = $item_short_desc;
            }
            function add_item_catagory($item_catagory) {
                $this->item_catagory = $item_catagory;
            }
            //Just for testing will remove later as these individual values do not need returns
            function get_item_id() {
                return $this->item_id;
            }
            function get_item_name() {
                return $this->item_name;
            }
            function get_item_remaining_quantity() {
                return $this->item_remaining_quantity;
            }
            function get_item_purchase_quantity() {
                return $this->item_purchase_quantity;
            }
            function get_item_price() {
                return $this->item_price;
            }
            function get_item_long_desc() {
                return $this->item_long_desc;
            }
            function get_item_short_desc() {
                return $this->item_short_desc;
            }
            function get_item_catagory() {
                return $this->item_catagory;
            }
        }
        $json = file_get_contents('stock_record.JSON');
        // Check if the file was read successfully
        if ($json === false) {
            die('Error reading the JSON file');
        }

        // Decode the JSON file
        $json_data = json_decode($json, true);

        // Check if the JSON was decoded successfully
        if ($json_data === null) {
            die('Error decoding the JSON file');
        }

        // Display data
        echo "<pre>";
        //print_r($json_data);
        echo "</pre>";
        $products_list = [];
        foreach ($json_data as $key => $value) {
            $new_item = new Item();
            $new_item->add_item_id($value['id']);
            $new_item->add_item_name($value['name']);
            $new_item->add_item_remaining_quantity($value['remaining_quantity']);
            $new_item->add_item_price($value['price']);
            $new_item->add_item_purchase_quantity(0); // default purchase quantity
            $new_item->add_item_long_desc($value['long_desc']);
            $new_item->add_item_short_desc($value['short_desc']);
            $new_item->add_item_catagory($value['catagory']);
            $products_list[] = $new_item;
        }
        //var_dump($products_list);
        echo "<br>";
        //Display of each item stored in the product list
        /*
        foreach ($products_list as $item) {
            echo "Item ID: " . $item->get_item_id() . "   <br>";
            echo "Item names: " . $item->get_item_name() . "   <br>";
            echo "Item remaining quantaty: " . $item->get_item_remaining_quantity() . "   <br>";
            echo "Item price: " . $item->get_item_price() . "   <br>";
            echo "Item purchas quantaty: " . $item->get_item_purchase_quantity() . "   <br>";
            echo "Item long description: " . $item->get_item_long_desc() . "   <br>";
            echo "Item short description: " . $item->get_item_short_desc() . "   <br>";
            echo "Item catagory: " . $item->get_item_catagory() . "   <br>";
        }
        */

        class Cart {
            // Properties
            public $acount_id;
            public $products = [];
            public $invoice;


            // Methods
            function add_acount_id($acount_id) {
                $this->acount_id = $acount_id;
            }
            function add_products($product_id, $quantity, $products_list) {
                foreach ($products_list as $item) {
                    $item_id = $item->get_item_id();
                    if ($item_id == $product_id) {
                        $item->add_item_purchase_quantity($quantity);
                        $this->products[] = $item;
                    }
                }
            }
            function calculate_invoice($cart_list) {
                $invoice = 0;
                $total_cost = 0;
                foreach ($cart_list as $item) {
                    $item_name = $item->get_item_name();
                    $item_price = $item->get_item_price();
                    $item_quantity = $item->get_item_purchase_quantity();
                    $total_cost = ($total_cost + ($item_price * $item_quantity));
                }
                $invoice = $total_cost;
                $this->invoice = $invoice;
            }
            //Just for testing will remove later as these individual values do not need returns
            function get_products() {
                return $this->products;
            }
            function get_acount_id() {
                return $this->acount_id;
            }
            function get_invoice() {
                return $this->invoice;
            }
            function remove_products() {
                //will try and create a way to remove particular products
            }
        }

        $cart = new Cart();
        $cart->add_acount_id(5);//temporarily hard coded
        $cart->add_products(1, 3, $products_list);
        $cart->add_products(2, 5, $products_list);
        $cart_list = $cart->get_products();
        $cart->calculate_invoice($cart_list);//has to come last
        //var_dump($cart_list);
        echo "Account ID: " . $cart->get_acount_id();
        echo "<br>";
        foreach ($cart_list as $item) {
            echo "Item ID: " . $item->get_item_id() . "   <br>";
            echo "Item names: " . $item->get_item_name() . "   <br>";
            echo "Item remaining quantaty: " . $item->get_item_remaining_quantity() . "   <br>";
            echo "Item price: " . $item->get_item_price() . "   <br>";
            echo "Item purchas quantaty: " . $item->get_item_purchase_quantity() . "   <br>";
            echo "Item long description: " . $item->get_item_long_desc() . "   <br>";
            echo "Item short description: " . $item->get_item_short_desc() . "   <br>";
            echo "Item catagory: " . $item->get_item_catagory() . "   <br>";
        }
        echo "<br>";
        echo "Invoice: " . $cart->get_invoice();
        echo "<br>";
    ?>
</body>
</html>
