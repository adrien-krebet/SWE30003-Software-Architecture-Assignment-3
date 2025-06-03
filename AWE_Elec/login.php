<?php
session_start();
require_once "classes/LoginHandler.php";

// Instantiate the login handler
$loginHandler = new LoginHandler();
$error = "";

// Handle POST submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $loginHandler->processLogin($email, $password);
    $error = $loginHandler->error;
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - AWE Electronics</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="brand-heading">
    <h1 class="display-5 fw-bold">AWE Electronics</h1>
    <p class="text-muted">Powering your tech dreams ⚡</p>
  </div>

  <div class="form-wrapper">
    <h3 class="text-center mb-4">Login</h3>
    <form method="POST">
      <div class="mb-3">
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-user"></i></span>
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
      </div>
      <div class="mb-3">
        <div class="input-group">
          <span class="input-group-text"><i class="fa fa-lock"></i></span>
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
      </div>
      <?php if ($error): ?>
        <p class="text-danger text-center"><?= $error ?></p>
      <?php endif; ?>
      <button type="submit" class="btn btn-primary w-100">Log In</button>
      <p class="mt-3 text-center">Don't have an account? <a href="signup.php" class="toggle-link">Sign up</a></p>
    </form>
  </div>
</body>
</html>
