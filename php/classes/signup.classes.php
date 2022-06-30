<?php

class Signup extends Dbh {

    protected function setUser($uid, $pwd, $email) {
        $stmt = $this->connect()->prepare('INSERT INTO users (users_uid, users_pwd, users_email) VALUES (?, ?, ?);');
        
        //password needs to be hashed
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        //hashed password should be inserted into the db
        if(!$stmt->execute(array($uid, $hashedPwd, $email))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    protected function checkUser($uid, $email) {
        $stmt = $this->connect()->prepare('SELECT users_uid FROM users WHERE users_uid = ? OR users_email = ?;');

        if(!$stmt->execute(array($uid, $email))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() > 0) {
            $resultCheck = false;
            return $resultCheck;
        }
        else {
            $resultCheck = true;
        }

        return $resultCheck;
    }

}