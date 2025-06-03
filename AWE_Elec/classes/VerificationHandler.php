<?php
require_once "Account.php";
require_once "AccountManager.php";

/**
 * Class VerificationHandler
 * Handles the logic for confirming the user’s email by verifying a 6-digit code.
 * If verification succeeds, the account is created and saved.
 */
class VerificationHandler {
    private AccountManager $manager;
    public string $message = "";
    public bool $success = false;

    /**
     * VerificationHandler constructor.
     * Initializes the AccountManager dependency.
     */
    public function __construct() {
        $this->manager = new AccountManager();
    }

    /**
     * Verifies the confirmation code entered by the user against the one stored in the session.
     * If valid, creates and saves a new account, and clears temporary session data.
     *
     * @param string $userCode  The code entered by the user
     * @return void
     */
    public function verifyCode(string $userCode): void {
        // Clean up user input and fetch stored session code
        $userCode = trim($userCode);
        $actualCode = trim($_SESSION["confirm_code"] ?? "");

        // Check if the provided code matches the session-stored one
        if ($userCode === $actualCode) {
            // Retrieve stored signup data from the session
            $email = $_SESSION["pending_email"];
            $password = $_SESSION["pending_password"];
            $access = $_SESSION["pending_access"];

            // Generate a unique user ID and create a new account
            $userID = $this->manager->generateUserID();
            $account = new Account($userID, $email, $password, $access);

            // Save the new account
            $this->manager->saveAccount($account);

            // Clear temporary session data
            unset($_SESSION["confirm_code"]);
            unset($_SESSION["pending_email"]);
            unset($_SESSION["pending_password"]);
            unset($_SESSION["pending_access"]);

            // Set confirmation success
            $this->message = "✅ Email confirmed! Your account is now active.";
            $this->success = true;
        } else {
            // Handle invalid code
            $this->message = "❌ Invalid confirmation code. Please try again.";
        }
    }
}
