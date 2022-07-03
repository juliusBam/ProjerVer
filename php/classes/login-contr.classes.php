<?php

// create a class with properties and methods
class loginContr extends Login {

    // properties needed for the login
    // set properties private, that only controllers have access to it
    private $uid;
    private $pwd;
    // grab data that user that user submitted and assign them to the properties above
    public function __construct($uid, $pwd) {
        // point to the properties in the class
        $this->uid = $uid;
        $this->pwd = $pwd;
    }

    // if empty input was checked and everything is fine, log in the user
    public function loginUser() {
        if($this->emptyInput() == false) {
            // echo "Empty input!";

            // if an input is empty, run he error message
            header("location: ../login.php?error=emptyinput");
            exit();
        }

        // get user from the database and log in
        $this->getUser($this->uid, $this->pwd);
    }

    // method to check if the input (unsername and password) is empty 
    private function emptyInput() {
        if(empty($this->uid) || empty($this->pwd)) {
            $result = false;
            return $result;
        } else {
            $result = true;
        }
        return $result;
    }

}
