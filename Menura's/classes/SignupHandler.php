<?php
class SignupHandler {
    public string $message = "";

    public function processSignup(string $email, string $password, string $confirmPassword): bool {
        $email = trim(strtolower($email));
        $password = trim($password);
        $confirmPassword = trim($confirmPassword);

        // Email format validation
        if (!preg_match("/^[a-z0-9._%+-]+@gmail\.com$/", $email)) {
            $this->message = "❌ Email must end with @gmail.com.";
            return false;
        }

        // Password validation: uppercase, digit, special char, min 6 chars
        if (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/", $password)) {
            $this->message = "❌ Password must include an uppercase letter, number, and special character.";
            return false;
        }

        // Confirm password
        if ($password !== $confirmPassword) {
            $this->message = "❌ Passwords do not match.";
            return false;
        }

        // Load users from JSON
        $file = "accounts.json";
        $users = [];

        if (file_exists($file)) {
            $json = file_get_contents($file);
            $users = json_decode($json, true) ?? [];
        }

        // Check if email already exists (case-insensitive match)
        foreach ($users as $existing) {
            if (strtolower($existing['email']) === $email) {
                $this->message = "❌ Email already exists!";
                return false;
            }
        }

        // Save new user
        $users[] = [
            "email" => $email,
            "password" => $password,
            "access" => "customer"
        ];

        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
        return true;
    }
}
