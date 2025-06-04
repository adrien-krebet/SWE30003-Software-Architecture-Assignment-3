<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8" />
 <meta name="description" content="SWE30003-Software Architectures and Design Assignment 3 " />
 <meta name="keywords" content="PHP" />
 <meta name="author" content="Joel Downie" />
 <title>Payment Menu Test</title>
 <link href= "styles/styles.css" rel="stylesheet"/><!-- Link to CSS file -->
</head>

<body>
    <header>
        <h1>Assignment 3 make the design and display the design</h1>
        <a href="payment.php">Temp way to payment:</a>
        <a href="cavehorse.php">CAVEHORSECAVEHORSECAVEHORSE:</a>
    </header>
    <section class="background_sheet"><!-- this class is used to create the background page like style in the css folder -->
        <h1>Login Page</h1>
        <p>Please fill out the login field bellow to be able to log into your my friends acount.</p>
        <form action = "payment.php" method = "post" >
            <fieldset>
                <legend>Login field:</legend>
                <p>Email:</p>
                <p>
                    <input type="text" name= "email" id="email" value="<?php echo $_POST['email']; ?>"/> <!-- preset field with value https://www.w3schools.com/tags/att_input_value.asp  -->
                </p>
                <p>Password:</p>
                <p>
                    <input type="text" name= "pword" id="pword"/>
                </p>
                <p>
                    <input id="submit" class="inputButtons" type= "submit" value="Log in"/> <input class="inputButtons" type= "reset" value="Clear"/>
                </p>
            </fieldset>
        </form>
        <h3>Infomation message:</h3>
        <?php
        ?>
    </section>
</body>
</html>
