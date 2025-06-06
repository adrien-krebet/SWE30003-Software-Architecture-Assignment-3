<?php
	if(!session_id()) {
		session_start();
	}
	$_SESSION["accID"] = "0002";
	$_SESSION["type"] = "0001";
	if (!isset ($_SESSION["accID"])) {
		$_SESSION["accID"] = "0002";
	}
	if (!isset ($_SESSION["type"])) { 
		$_SESSION["type"] = "0002";
	}
?>

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
			
			//retrieve account details based on json file
			$acc = file_get_contents("testaccountinfo.json");
			
			//Check if file was read
			if ($acc === false) {
				die("Error when reading the JSON file");
			}
			
			// Decode the JSON file
			$acc_data = json_decode($acc, true);
			
			//Check if JSOn was decoded successfully
			if ($acc_data === null) {
				die("Error decodnig the JSON file");
			}
			
			$data = [];
			foreach ($acc_data["accounts"] as $id) {
				if ($id["userid"] == $_SESSION["accID"]) {
					$data["name"] = $id["aname"];
					$name = $id["aname"];
					$data["email"] = $id["email"];
					$data["password"] = $id["password"];
				}
			}
			//Intro and button for changing data
			echo("<p>Hello " . $name . ".</p>");
			
			if (!isset($_POST["submit"])) {
				echo ('<form action = "menu.php" method = "POST">
				<input type = "submit" name = "submit" value = "Change Account Details">
				</form>');
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
			
			//
			if (isset($_POST["update"])) {
				$upname = $_POST["name"];
				$upemail = $_POST["email"];
				$uppswd = $_POST["password"];
				if($m->changeUserDetails($upname, $upemail, $uppswd)) {
					echo ("Data has been successfully changed");
				} else {
					echo ("An Error has occurred while updating your data");
				}
			}
			
			if (!isset($_POST["view"])) {
				echo ('<form action = "menu.php" method = "POST">
				<input type = "submit" name = "view" value = "View Order Details">
				</form>');
			} else {
				$m->retrieveOrders();
			}
		?>
		<p><a href="destroy.php">Restart session</a></p>
	</body>
</html>