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
            include 'account.php';
            echo "<h1>Login</h1>";
        ?>
            <form action="login.php" method="post">
            <fieldset>
                <legend>Log into your account</legend>
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
            $email = $_POST["email"];
            $password = $_POST["password"];
            if ($email == "") {
                $show = false;
            }
            else {
                $show = true;
            }
            if ($show == true) {
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
                $check = false;
                foreach ($acc_data["accounts"] as $id) {
                    if ($id["email"] == $email) {
                        if ($id["password"] == $password) {
                            $userid = $id["userid"];
                            $aname = $id["aname"];
                            //$email = $id["email"];
                            //$password = $id["password"];
                            $type = $id["type"];
                            $check = true;
                        }
                        else {
                            echo "<p>Your password is incorect please try again.</p>";
                        }
                    }
                    else {
                        echo "<p>Your email or password is incorect please try again.</p>";
                    }
                }
                if ($check == true) {
                    $account_info = new Account();
                    $account_info->set_account_name($aname);
                    $account_info->set_user_id($userid);
                    $account_info->set_email($email);
                    $account_info->set_password($password);
                    $account_info->set_type($type);
                    $account_info->create_account_session($userid);
                    header("Location: index.html");
                    exit;
                }
                else {
                    echo "<p>There was an error logging in please try agaen.</p>";
                }
            }
            else {
                echo "<p></p>";
            }
        ?>
    </body>
</html>
