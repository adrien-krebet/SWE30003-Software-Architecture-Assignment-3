<?php
class SignupHandler {
    public string $message = "";

    public function processSignup(string $email, string $password, string $confirmPassword): bool {
        $email = trim(strtolower($email));
        $password = trim($password);
        $confirmPassword = trim($confirmPassword);

        if (!preg_match("/^[a-z0-9._%+-]+@gmail\.com$/", $email)) {
            $this->message = "❌ Email must end with @gmail.com.";
            return false;
        }

        if (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/", $password)) {
            $this->message = "❌ Password must include an uppercase letter, number, and special character.";
            return false;
        }

        if ($password !== $confirmPassword) {
            $this->message = "❌ Passwords do not match.";
            return false;
        }

        $file = "accounts.json";
        $users = [];

        if (file_exists($file)) {
            $json = file_get_contents($file);
            $users = json_decode($json, true) ?? [];
        }

        if (isset($users[$email])) {
            $this->message = "❌ Email already exists!";
            return false;
        }

        $users[$email] = [
            "email" => $email,
            "password" => $password
        ];

        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
        return true;
    }
}
