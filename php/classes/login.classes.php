<?php

class Login extends Dbh {

    protected function getUser($uid, $pwd) {
        $stmt = $this->connect()->prepare('SELECT pwd FROM users WHERE userName = ? OR userEmail = ? AND status = 1;');

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

        //hashed password verification
        $checkPwd = md5($pwd) == $pwdHashed[0]["pwd"];

        //not hashed pwd verification [deprecated]
        //$checkPwd = ($pwdHashed[0]["pwd"] == $pwd);

        //check if the pwd match
        if($checkPwd == false)
        {
            $stmt = null;
            header("location: ../login.php?error=wrongpassword");
            exit();
        }

        //if pwd is the same, log in the user
        elseif($checkPwd == true) {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE userName = ? AND pwd = ? LIMIT 1;');

            //user can submit via userName
            if(!$stmt->execute(array($uid, md5($pwd)))) {
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

            //header("location: ../login.php?error=none");
            $url = "location: ../login.php?error=none&userID=".$user[0]["userID"]."&userName=".$user[0]["userName"]."&fk_roleID=".$user[0]["fk_roleID"];

            header($url);
                
            $stmt = null;
        }
    }


// Insert data into db "logs"
    public function logs($inputData){

        $fk_uid = $inputData['fk_userID'];
        $fk_type = $inputData['fk_logType'];

        $stmt = $this->connect()->prepare('INSERT INTO logs (fk_userID, fk_logType) VALUES (:fk_userID, :fk_logType);');
        if(!$stmt->execute(array($fk_uid, $fk_type))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }


}