<?php
class Account {
    public $userID;
    public $email;
    public $password;
    public $accessLevel;

    function __construct($userID, $email, $password, $accessLevel) {
        $this->userID = $userID;
        $this->email = $email;
        $this->password = $password;
        $this->accessLevel = $accessLevel;
    }

    function toArray() {
        return [
            'userID' => $this->userID,
            'email' => $this->email,
            'password' => $this->password,
            'accessLevel' => $this->accessLevel
        ];
    }
}
