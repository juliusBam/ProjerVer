<?php

class SignupContr extends Signup {

    private $uid;
    private $pwd;
    private $pwdRepeat;
    private $email;
    
    public function __construct($uid, $pwd, $pwdRepeat, $email) {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->email = $email;
    }

    public function signupUser() {
        if($this->emptyInput() == false) {
            // echo "Empty input!";
            header("location: ../login.php?error=emptyinput");
            exit();
        }
        if($this->invalidUid() == false) {
            // echo "Invalid username!";
            header("location: ../login.php?error=username");
            exit();
        }
        if($this->invalidEmail() == false) {
            // echo "Invalid email!";
            header("location: ../login.php?error=email");
            exit();
        }
        if($this->pwdMatch() == false)
        {
            // echo "Passwords don't match!";
            header("location: ../login.php?error=passwordmatch");
            exit();
        }
        if($this->uidTakenCheck() == false)
        {
            // echo "Username or email taken!";
            header("location: ../login.php?error=useroremailtaken");
            exit();
        }

        $this->setUser($this->uid, $this->pwd, $this->email);
    }

    private function emptyInput() {
        if(empty($this->uid) || empty($this->pwd) || empty($this->pwdRepeat) || empty($this->email)) {
            $result = false;
            return $result;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidUid() {
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->uid)) 
        {
            $result = false;
            return $result;
        } else 
        {
            $result = true;
        }
        return $result;
    }

    private function invalidEmail() {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) 
        {
            $result = false;
            return $result;
        }
        else 
        {
            $result = true;
        }
        return $result;
    }

    private function pwdMatch() {
        if ($this->pwd !== $this->pwdRepeat) 
        {
            $result = false;
            return $result;
        }
        else 
        {
            $result = true;
        }
        return $result;
    }

    private function uidTakenCheck() {
        if (!$this->checkUser($this->uid, $this->email)) 
        {
            $result = false;
            return $result;
        }
        else 
        {
            $result = true;
        }
        return $result;
    }

}