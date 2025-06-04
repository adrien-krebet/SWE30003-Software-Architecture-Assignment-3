<?php
session_start();
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (!empty($email) && !empty($password)) {
        if (!preg_match("/^[a-z0-9._%+-]+@gmail\.com$/", strtolower($email))) {
            $message = "❌ Email must end with @gmail.com.";
        } elseif (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/", $password)) {
            $message = "❌ Password must include an uppercase letter, number, and special character.";
        } elseif (strtolower($email) === "test@gmail.com") {
            $message = "❌ Email already exists!";
        } else {
            $_SESSION["signup_success"] = true;
            header("Location: signup.php");
            exit;
        }
    }
}

// Clear message after refresh
$justSignedUp = false;
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
      <button type="submit" class="btn btn-success w-100">Create Account</button>
    </form>

    <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
  </div>

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
