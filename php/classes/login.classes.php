<?php

class Login extends Dbh {

    protected function getUser($uid, $pwd) {
        $stmt = $this->connect()->prepare('SELECT pwd FROM users WHERE userName = ? OR userEmail = ?;');

        if(!$stmt->execute(array($uid, $pwd))) {
            $stmt = null;

            header("location: ../login.php?error=stmtfailed");
            exit();
        }

        //check if we get results from the database
        if($stmt->rowCount() == 0)
        {
            $stmt = null;
            header("location: ../login.php?error=usernotfound");
            exit();
        }

        //return pwd as an associated array
        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
       // $checkPwd = password_verify($pwd, $pwdHashed[0]["pwd"]);
        $checkPwd = ($pwdHashed[0]["pwd"] == $pwd);

        //check if the pwd match
        if($checkPwd == false)
        {
            $stmt = null;
            header("location: ../login.php?error=wrongpassword");
            exit();
        }

        //if pwd is the same, log in the user
        elseif($checkPwd == true) {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE userName = ? OR userEmail = ? AND pwd = ?;');

            //user can submit via userName or userEmail
            if(!$stmt->execute(array($uid, $uid, $pwd))) {
                $stmt = null;
                header("location: ../login.php?error=stmtfailed");
                exit();
            }

            //is the user in the db?
            if($stmt->rowCount() == 0)
            {
                $stmt = null;
                header("location: ../login.php?error=usernotfound");
                exit();
            }

            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION["userid"] = $user[0]["userID"];
            $_SESSION["useruid"] = $user[0]["userName"];

            $stmt = null;
        }
    }

}