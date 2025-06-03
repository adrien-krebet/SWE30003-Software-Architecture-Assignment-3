<?php
session_start();
require_once "classes/SignupHandler.php";

// Initialize signup handler
$handler = new SignupHandler();
$message = "";

// Handle signup POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    $handler->handleSignup($email, $password);
    $message = $handler->message;
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
  <!-- Alert Box -->
  <div class="position-fixed bottom-0 start-50 translate-middle-x mb-4" style="z-index: 9999;">
    <div id="alertBox" class="alert alert-danger d-none" role="alert"></div>
  </div>

  <!-- Header -->
  <div class="brand-heading">
    <h1 class="display-5 fw-bold">AWE Electronics</h1>
    <p class="text-muted">Powering your tech dreams ⚡</p>
  </div>

  <!-- Signup Form -->
  <div class="form-container">
    <h3 class="mb-3 text-center">Sign Up</h3>
    <form method="POST" id="signupForm">
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email (must end with @gmail.com)" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password (Uppercase, Number, Symbol)" required>
      </div>
      <button type="submit" class="btn btn-success w-100">Send Confirmation Code</button>
    </form>

    <!-- Message display -->
    <div class="message text-warning mt-3 text-center"><?= $message ?></div>
    <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
  </div>

  <!-- Client-side Validation -->
  <script>
    document.getElementById("signupForm").addEventListener("submit", function (e) {
      const email = document.querySelector("input[name='email']").value.trim().toLowerCase();
      const password = document.querySelector("input[name='password']").value.trim();
      const alertBox = document.getElementById("alertBox");

      const emailValid = /^[a-z0-9._%+-]+@gmail\.com$/.test(email);
      const passwordValid = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/.test(password);

      if (!emailValid || !passwordValid) {
        e.preventDefault();
        alertBox.classList.remove("d-none", "alert-success");
        alertBox.classList.add("show", "alert-danger");

        alertBox.innerHTML = !emailValid
          ? "❌ Email must end with <strong>@gmail.com</strong>."
          : "❌ Password must include a capital letter, a number, and a special character.";

        setTimeout(() => alertBox.classList.add("d-none"), 5000);
      }
    });
  </script>
</body>
</html>
