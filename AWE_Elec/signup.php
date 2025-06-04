<?php
session_start();
require_once "classes/SignupHandler.php";

// Instantiate SignupHandler
$signupHandler = new SignupHandler();
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    $signupHandler->handleSignup($email, $password);
    $message = $signupHandler->message;
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up - AWE Electronics</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <!-- Branding -->
  <div class="brand-heading text-center">
    <h1 class="display-5 fw-bold">AWE Electronics</h1>
    <p class="text-muted">Powering your tech dreams ⚡</p>
  </div>

  <!-- Signup Form -->
  <div class="form-container">
    <h3 class="text-center mb-3">Sign Up</h3>
    <form method="POST" id="signupForm" novalidate>
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email (must end with @gmail.com)" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password (Uppercase, Number, Symbol)" required>
      </div>
      <button type="submit" class="btn btn-success w-100">Create Account</button>
    </form>

    <!-- Server-side Message -->
    <?php if (!empty($message)): ?>
      <div class="message mt-3 text-warning text-center"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
  </div>

  <!-- Client-side validation -->
  <script>
    document.getElementById("signupForm").addEventListener("submit", function (e) {
      const email = document.querySelector("input[name='email']").value.trim().toLowerCase();
      const password = document.querySelector("input[name='password']").value.trim();
      const emailPattern = /^[a-z0-9._%+-]+@gmail\.com$/;
      const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/;

      if (!emailPattern.test(email) || !passwordPattern.test(password)) {
        e.preventDefault();
        alert(
          !emailPattern.test(email)
            ? "❌ Email must end with @gmail.com."
            : "❌ Password must include a capital letter, number, and special character."
        );
      }
    });
  </script>
</body>
</html>
