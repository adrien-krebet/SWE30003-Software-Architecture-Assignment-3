<?php
// Start the session to access session variables
session_start();

// Load the verification handler class
require_once "classes/VerificationHandler.php";

// Instantiate the handler
$verifier = new VerificationHandler();
$message = "";
$success = false;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $code = $_POST["code"] ?? "";
    $verifier->verifyCode($code);
    $message = $verifier->message;
    $success = $verifier->success;
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Confirmation</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container mt-5">
    <!-- Brand heading -->
    <div class="brand-heading text-center">
      <h1 class="fw-bold">AWE Electronics</h1>
      <p class="text-muted">Confirm your email to complete registration.</p>
    </div>

    <!-- Main form container -->
    <div class="form-container text-center">
      <h3 class="mb-3">Enter Confirmation Code</h3>

      <!-- Only show form if verification not yet successful -->
      <?php if (!$success): ?>
        <form method="POST">
          <div class="mb-3">
            <input type="text" name="code" class="form-control" placeholder="6-digit code" required>
          </div>
          <button type="submit" class="btn btn-success w-100">Verify</button>
        </form>
      <?php endif; ?>

      <!-- Display message -->
      <div class="message mt-4 text-warning"><?= $message ?></div>

      <!-- Post-verification navigation -->
      <?php if ($success): ?>
        <a href="login.php" class="btn btn-primary mt-3 w-100">Go to Login</a>
      <?php else: ?>
        <div class="d-flex justify-content-between mt-4">
          <a href="signup.php" class="btn btn-outline-light w-50 me-2">Back to Signup</a>
          <a href="login.php" class="btn btn-outline-success w-50 ms-2">Go to Login</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
