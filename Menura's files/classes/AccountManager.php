<?php
require_once "Account.php";

class AccountManager {
    private $filepath = "accounts.json";

    /**
     * Ensure JSON file exists before reading.
     */
    function getAllAccounts() {
        if (!file_exists($this->filepath)) {
            file_put_contents($this->filepath, json_encode([]));
        }

        $json = file_get_contents($this->filepath);
        return json_decode($json, true) ?? [];
    }

    /**
     * Save a new account to the accounts JSON file.
     */
    function saveAccount($account) {
        $accounts = $this->getAllAccounts();
        $accounts[] = $account->toArray();
        file_put_contents($this->filepath, json_encode($accounts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | LOCK_EX));
    }

    /**
     * Find an account by email (case-insensitive).
   
     */
    function findByEmail($email) {
        foreach ($this->getAllAccounts() as $acc) {
            if (strcasecmp($acc['email'], $email) === 0) {
                return $acc;
            }
        }
        return null;
    }

    /**
     * Generate a unique user ID.
     */
    function generateUserID() {
        return "U_" . str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT);
    }
}
