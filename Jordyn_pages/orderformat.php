<?php
	
	class OrderFormat implements InfoFormat {
		
		private $account_id;  //passed via session
		private $account_type; //passed via session
		private $order_info;
		
		function __construct () {
			$this->account_id = $_SESSION["accID"];
			$this->account_type = $_SESSION["type"];
			
			//retrieve order details based on json file
			$or = file_get_contents("exampleOrder.json");
			
			//Check if file was read
			if ($or === false) {
				die("Error when reading the JSON file");
			}
			
			// Decode the JSON file
			$or_data = json_decode($or, true);
			
			//Check if JSOn was decoded successfully
			if ($or_data === null) {
				die("Error decoding the JSON file");
			}
			
			$this->order_info = $or_data;
		}
		
		function retrieveOrders() {
			if($this->account_type == 1) {
				$data = $this->customerLayout();
			} elseif ($this->account_type == 2) {
				$data = $this->shipperLayout();
			} elseif ($this->account_type == 3) {
				$data = $this->adminLayout();
			} else {
				$data = "Error while reading orders.";
			}
			return $data;
		}
		
		function customerLayout() {
			$data = [];
			foreach ($this->order_info["orders"] as $id) {
				if ($id["userID"] == $_SESSION["accID"]) {
					$data[] = $id;
				}
			}
			return $data;
		}
		
		function shipperLayout() {
			$data = [];
			foreach ($this->order_info["orders"] as $id) {
				$data[] = $id;
			}
			return $data;
		}
		
		function adminLayout() {
			$data = [];
			foreach ($this->order_info["orders"] as $id) {
				$data[] = $id;
			}
			return $data;
		}
	}
?>