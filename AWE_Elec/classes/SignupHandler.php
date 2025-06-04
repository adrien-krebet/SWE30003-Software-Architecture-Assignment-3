<?php
require_once "Account.php";
require_once "AccountManager.php";

/**
 * Class SignupHandler
 * Handles user signup: validation and account creation.
 */
class SignupHandler {
    private AccountManager $accountManager;
    public string $message = "";

    /**
     * Constructor initializes AccountManager dependency.
     */
    public function __construct() {
        $this->accountManager = new AccountManager();
    }

    /**
     * Processes signup: validates input, checks for duplicates, and creates account.
     *
     * @param string $email    User's email address
     * @param string $password User's plain password
     * @return bool            True on success, false on failure
     */
    public function handleSignup(string $email, string $password): bool {
        $email = trim(strtolower($email));

        // Validate Gmail address format
        if (!preg_match('/^[a-z0-9._%+-]+@gmail\.com$/', $email)) {
            $this->message = "❌ Email must end with @gmail.com.";
            return false;
        }

        // Validate password complexity
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/', $password)) {
            $this->message = "❌ Password must include an uppercase letter, a number, and a special character.";
            return false;
        }

        // Check for duplicate email
        if ($this->accountManager->findByEmail($email)) {
            $this->message = "❌ Email already exists!";
            return false;
        }

        // Create and save the new account
        $userID = $this->accountManager->generateUserID();
        $account = new Account($userID, $email, $password, false); // `false` = regular user
        $this->accountManager->saveAccount($account);

        $this->message = "✅ Account created successfully. You can now log in.";
        return true;
    }
}
