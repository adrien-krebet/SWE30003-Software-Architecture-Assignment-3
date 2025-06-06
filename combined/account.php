<?php
    echo "<h1>Acount</h1>";
    class Account {
        public $user_id, $account_name, $email, $password, $type;

        function set_user_id($user_id) { $this->user_id = $user_id; }
        function set_account_name($account_name) { $this->account_name = $account_name; }
        function set_email($email) { $this->email = $email; }
        function set_password($password) { $this->password = $password; }
        function set_type($type) { $this->type = $type; }

        function get_user_id() { return $this->user_id; }
        function get_account_name() { return $this->account_name; }
        function get_email() { return $this->email; }
        function get_password() { return $this->password; }
        function get_type() { return $this->type; }
        function create_account_session($account_id) {return "1";}//make actual function here
    }
?>
