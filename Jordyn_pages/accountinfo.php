<?php
	//Summon Interface
	require ("Format.php");
	require_once ("orderformat.php");
	
	class Menu implements InfoFormat {

		private $account_id;  //passed via session
		private $account_type; //passed via session
		
		
		//Constructor
		function __construct () {
			
			$this->account_id = $_SESSION["accID"];
			$this->account_type = $_SESSION["type"];
			//echo $this->account_id;
			//echo $this->account_type;
		}
		
		function retrieveOrders() {
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
			
			$data = [];
			foreach ($or_data["orders"] as $id) {
				if ($id["userID"] == $_SESSION["accID"]) {
					$data[] = $id;
				}
			}
			
			$new_order = [];
			$name = "";
			$quant = "";
			echo "<p><table width = '100%' border = '1'>";
			echo "<tr><th>Order_ID</th><th>Item Name</th><th>Item Quantity</th><th>Order Status</th></tr>";
			for($i = 0; $i < count($data); $i++) {
				//print_r($data[$i]);
				$order = $data[$i];
				foreach($order as $key=>$value) {
					$new_order[] = $value;
				}
				$id = $new_order[0];
				$user = $new_order[1];
				$status = $new_order[2];
				$collection = $new_order[3];
				$address = $new_order[4];
				$postcode = $new_order[5];
				$items = $new_order[6];
				//print_r ($items);
				echo "<tr><td>{$id}</td>";
				foreach($items as $key=>$stock) {
					$name .= " " . $stock["name"];
					$quant .= " " . $stock["quantity"];
				}
				echo "<td>{$name}</td>";
				echo "<td>{$quant}</td>";
				echo "<td>{$status}</td></tr>";
				
				array_splice($new_order, 0, count($new_order));
				$name = " ";
				$quant = " ";
			}
			echo "</table></p>";
		}
		
		function changeUserDetails($name, $email, $pswd) {
			//code inspired (and changed) by https://stackoverflow.com/questions/17806224/how-to-update-edit-a-json-file-using-php
			$json = file_get_contents("testaccountinfo.json");
			$json_data = json_decode($json, true);
			foreach($json_data["accounts"] as &$record) {
				if($record["userid"] === $_SESSION["accID"]) {
					$record["aname"] = $name;
					$record["email"] = $email;
					$record["password"] = $pswd;
					//print_r ($record);
				}
			}
			$new_json_data = json_encode($json_data, JSON_PRETTY_PRINT);
			file_put_contents("testaccountinfo.json", $new_json_data);
			if(empty($new_json_data)) {
				return false;
			} else {
				return true;
			}
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
