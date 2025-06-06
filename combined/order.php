<?php
    //sequence check will have already been called in
    //https://stackoverflow.com/questions/7895335/append-data-to-a-json-file-with-php
    require_once 'sequence_check.php';

    class Order extends Sequence_check {
        public $order_account_id;
        public $order_collection_method;
        public $order_items;//cart
        public $order_contact_details;//from acount
        public $order_address;
        public $order_postcode;
        function verify_data($data_input) {
            if ($data_input == true) {
                $error_message = "";
            }
            else {
                $error_message = "There was an issue with your payment transaction. please try again.";
            }
            $this->error_message = $error_message;
            return $error_message;
        }
        function set_order_account_id($order_account_id) {
            $this->order_account_id = $order_account_id;
        }
        function set_order_collection_method($order_collection_method) {
            $this->order_collection_method = $order_collection_method;
        }
        function set_order_items($order_items) {
            $this->order_items = $order_items;
        }
        function set_order_contact_details($order_contact_details) {
            $this->order_contact_details = $order_contact_details;
        }
        function set_order_address($order_address) {
            $this->order_address = $order_address;
        }
        function set_order_postcode($order_postcode) {
            $this->order_postcode = $order_postcode;
        }
        function get_order_account_id() {
            return $this->order_account_id;
        }
        function get_order_collection_method() {
            return $this->order_collection_method;
        }
        function get_order_items() {
            return $this->order_items;
        }
        function get_order_contact_details() {
            return $this->order_contact_details;
        }
        function get_order_address() {
            return $this->order_address;
        }
        function get_order_postcode() {
            return $this->order_postcode;
        }
        function send_email($email_address) {//very simplified function to simulate sending an email
            $result = "Your order has been complete. an email has been sent to $email_address ";
            return $result;
        }
        function create_order(){//maybe remove CART AND PAYMENT OBJECTS HERE?????????????????????????????
            //echo "create_order() called<br>";

            $order_cart = $this->get_order_items();
            $order_items = $order_cart->get_products();
            var_dump($order_cart);

            $jsonString = file_get_contents('stock_record.json');
            $data = json_decode($jsonString, true);
            foreach ($order_items as $item) {
                $item_id = $item->get_item_id();
                $purchase_quantity = $item->get_item_purchase_quantity();
                foreach ($data as $key => $entry) {
                    if ($entry['id'] == $item_id) {
                        $remaining_quantity = $data[$key]['remaining_quantity'];
                        //echo "$remaining_quantity<br>";
                        $new_quantity = $remaining_quantity - $purchase_quantity;
                        $data[$key]['remaining_quantity'] = $new_quantity;
                    }
                }
            }

            $newJsonString = json_encode($data);
            file_put_contents('stock_record.json', $newJsonString);

            $file = 'order_record.json';
            $json = json_decode(file_get_contents($file), true) ?? ['orders' => []];

            // count order nums and increment for the next order in format '000X' yada yada
            // prolly rework this for an increasing order count stored er somewhere
            // https://www.php.net/manual/en/function.str-pad.php
            $order_id = str_pad(count($json['orders']) + 1, 4, "0", STR_PAD_LEFT);

            $order_entry = [
                'orderID' => $order_id,
                'userID' => $this->get_order_account_id(),
                // change this between whatever
                'orderStatus' => "Being Processed",
                'collectionMethod' => $this->get_order_collection_method(),
                'address' => $this->get_order_address(),
                'postcode' => $this->get_order_postcode(),
                'items' => array_map(function($item) {
                    return [
                        'name' => $item->get_item_name(),
                        'quantity' => (string) $item->get_item_purchase_quantity()
                    ];
                }, $this->get_order_items()->get_products())
            ];

            $json['orders'][] = $order_entry;
            // put :)
            if (file_put_contents($file, json_encode($json, JSON_PRETTY_PRINT)) === false) {
                echo "<p>Error: Could not write to order_record.json</p>";
            }
        }
    }
?>
