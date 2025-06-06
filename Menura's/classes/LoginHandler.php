<?php
class LoginHandler {
    public string $error = "";

    public function processLogin(string $email, string $password): bool {
        $email = trim(strtolower($email));
        $password = trim($password);

        $file = "accounts.json";
        if (!file_exists($file)) {
            $this->error = "❌ No accounts found.";
            return false;
        }

        $users = json_decode(file_get_contents($file), true) ?? [];

        foreach ($users as $user) {
            if (strtolower($user["email"]) === $email && $user["password"] === $password) {
                $_SESSION["user"] = [
                    "email" => $user["email"],
                    "access" => $user["access"] ?? "customer"
                ];
                return true;
            }
        }

        $this->error = "❌ Invalid email or password.";
        return false;
    }
}
