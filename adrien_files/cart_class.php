<!DOCTYPE html>
<html>
<body>
    <header>
        <!--<h1>Assignment 3 view cart example</h1>
        <a href="index.html">Home Page:</a>
        <a href="payment.html">Temp way to payment:</a>
        <a href="cavehorse.html">CAVEHORSECAVEHORSECAVEHORSE:</a>
        <a href="payment_class.php">payment_class:</a>
        <a href="cart_class.php">cart_class:</a>-->
    </header>
    <?php
        //https://www.w3schools.com/php/php_oop_classes_objects.asp
        //https://www.w3schools.com/js/js_json_datatypes.asp
        //https://www.geeksforgeeks.org/php/how-to-parse-a-json-file-in-php/
        //https://www.w3schools.com/php/php_json.asp
        //https://stackoverflow.com/questions/42233076/get-specific-object-from-specific-id-json
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

        class Cart {
        public $account_id;
        public $products = [];
        public $invoice = 0;

        function add_account_id($id) {
            $this->account_id = $id;
        }

        function add_products($product_id, $quantity, $products_list) {
            foreach ($products_list as $item) {
                if ($item->get_item_id() == $product_id) {
                    $item->add_item_purchase_quantity($quantity);
                    $this->products[] = $item;
                    return; // stop after adding the matching product
                }
            }
        }

        function calculate_invoice($cart_list) {
            $total = 0;
            foreach ($cart_list as $item) {
                $total += $item->get_item_price() * $item->get_item_purchase_quantity();
            }
            $this->invoice = $total;
        }

        function get_products() {
            return $this->products;
        }

        function get_account_id() {
            return $this->account_id;
        }

        function get_invoice() {
            return $this->invoice;
        }

        function remove_products($product_id) {
            foreach ($this->products as $i => $item) {
                if ($item->get_item_id() == $product_id) {
                    unset($this->products[$i]);
                }
            }
            $this->products = array_values($this->products); // reindex
        }

        function remove_all_products() {
            $this->products = [];
            $this->invoice = 0;
        }
        // i just removed the print stuff cos it printed from the record but i have a backup
    }
    ?>
</body>
</html>
