<!DOCTYPE html>
<html>
    <body>
        <nav>
            <a href="index.html">Home Page:</a>
            <a href="payment.html">Temp way to payment:</a>
            <a href="cavehorse.html">CAVEHORSECAVEHORSECAVEHORSE:</a>
            <!--<a href="AWE_Elec/login.php">Login Page (local only)</a>
            <a href="AWE_Elec/signup.php">Signup Page (local only)</a>-->
            <a href="catalogue.php">Catalogue stuff:</a>
            <a href="order.php">Order stuff:</a>
            <a href="view_cart.php">View Cart</a>
            <a href="payment.php">payment stuff:</a>
            <a href="login.php">login:</a>
            <a href="signup.php">signup:</a>
        </nav>
        <?php
            session_start();
            include 'account.php';
            echo "<h1>Signup</h1>";
        ?>
        <form action="signup.php" method="post">
            <fieldset>
                <legend>Create account</legend>
                <p>Account name:</p>
                <input type="text" name="account_name" id="account_name" required />

                <p>Email:</p>
                <input type="text" name="email" id="email" required />

                <p>Password:</p>
                <input type="text" name="password" id="password" required />

                <p>
                    <input type="submit" value="Submit account details" />
                    <input type="reset" value="Clear" />
                </p>
            </fieldset>
        </form>
        <?php
            $account_name = $_POST["account_name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $access_level = 1;
            //echo "<p>$account_name $email $password</p>";
            $acc = file_get_contents("accountinfo.json");

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
            $check = true;
			foreach ($acc_data["accounts"] as $id) {
				if ($id["email"] == $email) {
                    echo "<p>$email already exists and can not be used.</p>";
                    $check = false;
				}
                else {
                    $check = true;
                }
			}
            if (($check == true) and $email != "") {
                $file = 'accountinfo.json';
                $json = json_decode(file_get_contents($file), true) ?? ['accounts' => []];

                // count order nums and increment for the next order in format '000X' yada yada
                // prolly rework this for an increasing order count stored er somewhere
                // https://www.php.net/manual/en/function.str-pad.php
                $account_id = str_pad(count($json['accounts']) + 1, 4, "0", STR_PAD_LEFT);

                $account_entry = [
                    'userid' => $account_id,
                    'aname' => $account_name,
                    // change this between whatever
                    'email' => $email,
                    'password' => $password,
                    'type' => $access_level//default user acount level
                ];

                $json['accounts'][] = $account_entry;
                // put :)
                if (file_put_contents($file, json_encode($json, JSON_PRETTY_PRINT)) === false) {
                    echo "<p>Error: Could not write to order_record.json</p>";
                }
                $account_info = new Account();
                $account_info->set_account_name($account_name);
                $account_info->set_user_id($account_id);
                $account_info->set_email($email);
                $account_info->set_password($password);
                $account_info->set_type($access_level);
                $account_info->create_account_session($account_id, $access_level, $account_name);


                //asign vairables to account class and then create accountid session
                //rerout to index
                header("Location: index.html");
                exit;
            }
        ?>
    </body>
</html>
