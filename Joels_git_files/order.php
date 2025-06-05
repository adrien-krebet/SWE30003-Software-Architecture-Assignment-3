<?php
    //sequence check will have already been called in
    class Order extends Sequence_check {
        public $order_account_id;
        public $order_collection_method;
        public $order_items;//cart
        public $order_contact_details;//from acount
        public $order_address;
        public $order_postcode;
        function veryify_data($payment_status) {
            if ($payment_status == true) {
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
        function create_order(){
            $i = 1;
        }
    }
?>
