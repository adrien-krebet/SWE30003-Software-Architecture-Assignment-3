<?php
session_start();
require_once "classes/LoginHandler.php";  // Updated path if needed

$loginHandler = new LoginHandler();
$error = "";

// If form submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (!$loginHandler->processLogin($email, $password)) {
        $error = $loginHandler->error;
    } else {
        // Redirect after successful login
        header("Location: index.php");
        exit;
    }
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

<body class="bg-dark text-white">
  <div class="brand-heading text-center">
    <h1 class="display-5 fw-bold">AWE Electronics</h1>
    <p class="text-muted">Powering your tech dreams ⚡</p>
  </div>

  <div class="form-wrapper">
    <h3 class="text-center mb-4">Login</h3>

    <form method="POST" novalidate>
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

      <?php if (!empty($error)): ?>
        <p class="text-danger text-center"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <button type="submit" class="btn btn-success w-100">Log In</button>

      <p class="mt-3 text-center">
        Don’t have an account? <a href="signup.php" class="toggle-link">Sign up</a>
      </p>
    </form>
  </div>
</body>
</html>
