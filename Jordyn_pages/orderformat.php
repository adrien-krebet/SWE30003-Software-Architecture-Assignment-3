<?php
	
	class OrderFormat implements InfoFormat {
		
		private $account_id;  //passed via session
		private $account_type; //passed via session
		private $order_info;  //get order info from order record
		
		function __construct () {
			$this->account_id = $_SESSION["accID"];
			$this->account_type = $_SESSION["type"];
		}
		
		function retrieveOrders($userid) {
			
		}
		
		function customerLayout() {
			if($this->account_type = 1) {
				return "customer";
			} else {
				return false;
			}
		}
		
		function shipperLayout() {
			if($this->account_type = 2) {
				return "shipper";
			} else {
				return false;
			}
		}
		
		function adminLayout() {
			if($this->account_type = 3) {
				return "admin";
			} else {
				return false;
			}
		}
	}
?>