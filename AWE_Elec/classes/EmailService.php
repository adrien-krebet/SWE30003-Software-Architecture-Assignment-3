<?php
// Load required PHPMailer classes
require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/SMTP.php";
require_once "PHPMailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * EmailService handles sending confirmation emails via SMTP.
 * This class wraps PHPMailer into a reusable component for sending emails.
 */
class EmailService
{
    /**
     * @var string Stores the error message in case of failure
     */
    private string $error = "";

    /**
     * Sends a confirmation email with a verification code to the specified recipient.
     *
     * @param string $recipientEmail The recipient's email address
     * @param string|int $code The 6-digit confirmation code
     * @return bool True if the email was sent successfully, false otherwise
     */
    public function sendConfirmationEmail(string $recipientEmail, $code): bool
    {
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "aweelectrnoics@gmail.com";     // Sender's email
            $mail->Password = "cldstosoyemnsndb";              // App-specific password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email content
            $mail->setFrom("aweelectrnoics@gmail.com", "AWE Electronics");
            $mail->addAddress($recipientEmail);
            $mail->Subject = "Confirmation Code";
            $mail->Body = "Hi!\n\nYour confirmation code is: $code\n\nEnter it on the website to complete your signup.";

            // Send email
            $mail->send();
            return true;

        } catch (Exception $e) {
            // Capture and store error for later retrieval
            $this->error = "❌ Could not send confirmation email. Error: <code>" . $mail->ErrorInfo . "</code>";
            return false;
        }
    }

    /**
     * Retrieves the last error message from a failed send attempt.
     *
     * @return string Error message
     */
    public function getError(): string
    {
        return $this->error;
    }
}
