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
    </body>
</html>
