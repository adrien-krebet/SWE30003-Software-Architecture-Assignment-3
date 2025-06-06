<?php
abstract class Sequence_check {
    public $error_message;
    abstract public function verify_data($data_input);
}
?>