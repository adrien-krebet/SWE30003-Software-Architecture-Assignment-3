<?php
session_start();
require_once "classes/SignupHandler.php";

$handler = new SignupHandler();
$message = "";
$justSignedUp = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    if ($handler->processSignup($email, $password, $confirmPassword)) {
        $_SESSION["signup_success"] = true;
        header("Location: signup.php");
        exit;
    } else {
        $message = $handler->message;
    }
}

if (isset($_SESSION["signup_success"])) {
    $justSignedUp = true;
    unset($_SESSION["signup_success"]);
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - AWE Electronics</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="stylesheet" href="styles.css" />
</head>

<body class="bg-dark text-white">
  <div class="brand-heading text-center mt-4">
    <h1 class="display-5 fw-bold">AWE Electronics</h1>
    <p class="text-muted">Powering your tech dreams ⚡</p>
  </div>

  <div class="form-container bg-black p-4 rounded shadow mx-auto mt-4" style="max-width: 400px;">
    <h3 class="text-center mb-3">Sign Up</h3>

    <?php if (!empty($message)): ?>
      <div class="alert alert-warning text-center"><?= htmlspecialchars($message) ?></div>
    <?php elseif ($justSignedUp): ?>
      <div class="alert alert-success text-center">✅ Account created successfully.</div>
    <?php endif; ?>

    <form method="POST" id="signupForm" novalidate>
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email (must end with @gmail.com)" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password (Uppercase, Number, Symbol)" required>
      </div>
      <div class="mb-3">
        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
      </div>
      <button type="submit" class="btn btn-success w-100">Create Account</button>
    </form>

    <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
