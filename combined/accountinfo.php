<?php
	//Summon Interface
	require_once ("Format.php");
	require_once ("orderformat.php");
	
	class Menu implements InfoFormat {

		private $account_id;  //passed via session
		private $account_type; //passed via session
		
		
		//Constructor
		function __construct () {
			
			$this->account_id = $_SESSION["account_id"];
			$this->account_type = $_SESSION["type"];
		}
		
		function showOrders() {
			//all variables
			$ro = New orderformat();
			$data = $ro->retrieveOrders();
			$new_order = [];
			$oname = "";
			$quant = "";
			
			//start of table
			echo "<p><table width = '100%' border = '1'>";
			if($this->account_type == 1) {
				$table = $this->customerLayout();
			} elseif ($this->account_type == 2) {
				$table = $this->shipperLayout();
			} elseif ($this->account_type == 3) {
				$table = $this->adminLayout();
			} else {
				$table = "Error with table.";
			}
			echo $table;
			
			//removing data from an array
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
				
				//getting specific items and appending
				foreach($items as $key=>$stock) {
					$oname .= $stock["name"] . "<br>";
					$quant .= $stock["quantity"] . "<br>";
				}
				
				//layout of table
				if($this->account_type == 1) {
					$msg = $this->customerTable($id, $oname, $quant, $status);
				} elseif ($this->account_type == 2) {
					$msg = $this->shipperTable($id, $oname, $quant, $collection, $address, $postcode, $status);
				} elseif ($this->account_type == 3) {
					$msg = $this->adminTable($user, $id, $oname, $quant, $collection, $address, $postcode, $status);
				} else {
					$msg = "Error with table rows.";
				}
				echo $msg;
				
				//reset variables for new data
				array_splice($new_order, 0, count($new_order));
				$oname = " ";
				$quant = " ";
			}
			echo "</table></p>";
		}
		
		function changeOrderDetails($search_id, $new_status) {
			//code inspired (and changed) by https://stackoverflow.com/questions/17806224/how-to-update-edit-a-json-file-using-php
			if (strlen($search_id) != 0) {
				$json = file_get_contents("exampleOrder.json");
				$json_data = json_decode($json, true);
				foreach($json_data["orders"] as &$record) {
					if($record["orderID"] === $search_id) {
						$record["orderStatus"] = $new_status;
					}
				}
				$new_json_data = json_encode($json_data, JSON_PRETTY_PRINT);
				file_put_contents("order_record.json", $new_json_data);
				if(empty($new_json_data)) {
					return false;
				} else {
					return true;
				}
			} else {
				return false;
			}
		}
		
		function getUserDetails($user) {
			//retrieve account details based on json file
			$acc = file_get_contents("accountinfo.json");
			
			//Check if file was read
			if ($acc === false) {
				die("Error when reading the JSON file");
			}
			
			//Decode the JSON file
			$acc_data = json_decode($acc, true);
			
			//Check if JSOn was decoded successfully
			if ($acc_data === null) {
				die("Error decodnig the JSON file");
			}
			
			//Get all account details
			$data = [];
			foreach ($acc_data["accounts"] as $id) {
				if ($id["userid"] == $user) {
					$data["name"] = $id["aname"];
					$name = $id["aname"];
					$data["email"] = $id["email"];
					$data["password"] = $id["password"];
				}
			}
			return $data;
		}
		
		function changeUserDetails($name, $email, $pswd) {
			//code inspired (and changed) by https://stackoverflow.com/questions/17806224/how-to-update-edit-a-json-file-using-php
			$json = file_get_contents("accountinfo.json");
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
			file_put_contents("accountinfo.json", $new_json_data);
			if(empty($new_json_data)) {
				return false;
			} else {
				return true;
			}
		}
		
		function customerLayout() {
			return "<tr><th>Order_ID</th><th>Item Name</th><th>Item Quantity</th><th>Order Status</th></tr>";
		}
		
		function customerTable($id, $oname, $quant, $status) {
			return "<tr><td>{$id}</td>
				<td>{$oname}</td>
				<td>{$quant}</td>
				<td>{$status}</td></tr>";
		}
		
		function shipperLayout() {
			return "<tr><th>Order_ID</th><th>Item Name</th><th>Item Quantity</th><th>Collection Type</th><th>Address</th><th>Postcode</th><th>Order Status</th></tr>";
		}
		
		function shipperTable($id, $oname, $quant, $collection, $address, $postcode, $status) {
			return "<tr><td>{$id}</td>
				<td>{$oname}</td>
				<td>{$quant}</td>
				<td>{$collection}</td>
				<td>{$address}</td>
				<td>{$postcode}</td>
				<td>{$status}</td>
				</tr>";
		}
		
		function adminLayout() {
			return "<tr><th>Username</th><th>User_ID</th><th>Order_ID</th><th>Item Name</th><th>Item Quantity</th><th>Collection Type</th><th>Address</th><th>Postcode</th><th>Order Status</th></tr>";
		}
		
		function adminTable($user, $id, $oname, $quant, $collection, $address, $postcode, $status) {
			$u_id = $this->getUserDetails($user);
			return "<tr>
				<td>{$u_id['name']}</td>
				<td>{$user}</td>
				<td>{$id}</td>
				<td>{$oname}</td>
				<td>{$quant}</td>
				<td>{$collection}</td>
				<td>{$address}</td>
				<td>{$postcode}</td>
				<td>{$status}</td></tr>";
		}
	}
?>
