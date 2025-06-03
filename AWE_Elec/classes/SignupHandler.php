<?php
require_once "Account.php";
require_once "AccountManager.php";
require_once "EmailService.php";

/**
 * Class SignupHandler
 * Handles the user signup logic including input validation, session preparation,
 * and sending the confirmation email using the EmailService class.
 */
class SignupHandler {
    private AccountManager $accountManager;
    private EmailService $emailService;
    public string $message = "";

    /**
     * SignupHandler constructor.
     * Initializes dependencies: AccountManager and EmailService.
     */
    public function __construct() {
        $this->accountManager = new AccountManager();
        $this->emailService = new EmailService();
    }

    /**
     * Validates input, checks for existing accounts, stores data in session, and sends confirmation email.
     *
     * @param string $email      The user's email address
     * @param string $password   The user's raw password
     * @return bool              True if the process succeeds, false otherwise
     */
    public function handleSignup(string $email, string $password): bool {
        // Sanitize and standardize the email
        $email = trim(strtolower($email));

        // Validate the email format
        if (!preg_match('/^[a-z0-9._%+-]+@gmail\.com$/', $email)) {
            $this->message = "❌ Email must end with @gmail.com.";
            return false;
        }

        // Validate password requirements: uppercase, number, special char, and length
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/', $password)) {
            $this->message = "❌ Password must include an uppercase letter, a number, and a special character.";
            return false;
        }

        // Ensure the email is not already used
        if ($this->accountManager->findByEmail($email)) {
            $this->message = "❌ Email already exists!";
            return false;
        }

        // Generate confirmation code and store everything in the session
        $confirmCode = rand(100000, 999999);
        $_SESSION["pending_email"] = $email;
        $_SESSION["pending_password"] = $password;
        $_SESSION["confirm_code"] = $confirmCode;

        // Attempt to send confirmation email
        if ($this->emailService->sendConfirmationEmail($email, $confirmCode)) {
            header("Location: verify.php");
            exit;
        } else {
            // If sending fails, return error from EmailService
            $this->message = $this->emailService->getError();
            return false;
        }
    }
}
