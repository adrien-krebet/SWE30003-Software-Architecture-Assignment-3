<?php
require_once "AccountManager.php";

/**
 * Handles user login validation and session management.
 */
class LoginHandler {
    private AccountManager $manager;
    public string $error = "";

    public function __construct() {
        $this->manager = new AccountManager();
    }

    /**
     * Processes login based on provided email and password.
     * If valid, stores user session and redirects.
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function processLogin(string $email, string $password): bool {
        $user = $this->manager->findByEmail($email);

        if ($user && $user["password"] === $password) {
            $_SESSION["user"] = $user;
            header("Location: dashboard.php");
            exit;
        }

        $this->error = "Invalid credentials!";
        return false;
    }
}
