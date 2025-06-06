<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Menu</title>
		<meta charset="utf-8" />
		<meta name="description" content="Menu, shows account info and orders, info can be changed" />
	</head>
	<body>
		<h2>AWE Electronics</h2>
		<?php
			require_once("accountinfo.php");
			$m = new Menu();
			$data = $m->getUserDetails($_SESSION["account_id"]);
			if($_SESSION["type"] == 1) {
				$t = "customer";
			} elseif ($_SESSION["type"] == 2) {
				$t = "Shipper";
			} elseif ($_SESSION["type"] == 3) {
				$t = "Admin";
			}
			
			//Intro and button for changing data
			echo("<p>Hello " . $data["name"] . ".</p>");
			echo("<p>This account type is " . $t . ".");
			
			if (!isset($_POST["submit"])) {
				echo ('<form action = "menu.php" method = "POST">
				<input type = "submit" name = "submit" value = "Change Account Details">
				</form>');
				if($_SESSION["type"] == 2) {
					echo ('<form action = "menu.php" method = "POST">
					<input type = "submit" name = "change" value = "Update Order status">
					</form>');
				}
			} else {
				//find relevant json info
				//Form code taken and altered from Digital FOX https://www.youtube.com/watch?v=TMAwyq14FUI -> 6:03
				foreach ($data as $key => $value) {
					echo ('<form action="menu.php? $_SERVER["QUERY_STRING"]" method = "POST">
					<p><label>'. $key .'</label>
					<input type = "text" name = "'. $key .'" value = "'. $value .'">
					<input type = "submit" name = "update" value = "Update"></p>');
				}
				echo ('<p><input type = "submit" name = "back" value = "Go Back"></p></form>');
			}
			
			//update account details
			if (isset($_POST["update"])) {
				if (strlen($_POST["name"]) != 0 && strlen($_POST["email"]) != 0 && strlen($_POST["password"]) != 0) {
					$upname = $_POST["name"];
					$upemail = $_POST["email"];
					$uppswd = $_POST["password"];
					$pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
					if(preg_match($pattern, $upemail) == 1) {
						if($m->changeUserDetails($upname, $upemail, $uppswd)) {
							echo ("Data has been successfully changed");
						} else {
							echo ("An Error has occurred while updating your data");
						}
					} else {
						echo ("Please enter a valid email address, ie. blank@gmail.com");
					}
				} else {
					echo ("Fields cannot be empty, please only change what you want to update");
				}
			}
			
			//update order status
			if (isset($_POST["change"])) {
				echo ('<form action = "menu.php" method = "POST">
					<label>Order ID:</label> 
					<input type = "text" name = "id">
					<select id = "status" name = "status">
						<option value = "Pending">Pending</option>
						<option value = "In progress">In progress</option>
						<option value = "Complete">Complete</option>
					</select>
					<input type = "submit" name = "ustatus" value = "Update">
					</form>');
			} elseif (isset($_POST["ustatus"])) {
				$search_id = $_POST["id"];
				$new_status = $_POST["status"];
				if($m->changeOrderDetails($search_id, $new_status)) {
					echo ("Order has been successfully changed");
				} else {
					echo ("An Error has occurred while updating an order");
				}
			}
			
			if (!isset($_POST["view"])) {
				echo ('<form action = "menu.php" method = "POST">
				<input type = "submit" name = "view" value = "View Order Details">
				</form>');
			} else {
				$m->showOrders();
			}
			//<p><a href="destroy.php">Restart session</a></p>
		?>
	</body>
</html>