<?php

// create the class with the extension to the database connection
class Login extends Dbh {

    // check if the column pwd from the database is equal to the pwd the user, with given username 
    // and status = 1 (active), wants to log in with
    protected function getUser($uid, $pwd) {
        // sql query to select data from database
        $stmt = $this->connect()->prepare('SELECT pwd FROM users WHERE userName = ? AND status = 1;');
        if(!$stmt->execute(array($uid))) {
            $stmt = null;

            header("location: ../login.php?error=stmtfailed");
            exit();
        }

        // try to get the user; if we have 0 results from the database, the user will get an error message
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

            //user can submit via userName and password
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


            //user login will be assigned to "logs"
            $fk_uid = $user[0]["userID"]; 
            $stmtLogs = $this->connect()->prepare('INSERT INTO logs (fk_userID, fk_logType) VALUES (:fk_userID, 2);'); 
            $stmtLogs->bindParam("fk_userID", $fk_uid, PDO::PARAM_INT);
           // $stmt->bindParam("fk_logType", $fk_type, PDO::PARAM_INT);
    
            if(!$stmtLogs->execute()) {
                $stmtLogs = null;
                header("location: ../login.php?error=stmtfailed");
                exit();
            }
    
            $stmt = null;
            //header("location: ../login.php?error=none");
            $url = "location: ../login.php?error=none&userID=".$user[0]["userID"]."&userName=".$user[0]["userName"]."&fk_roleID=".$user[0]["fk_roleID"];

            header($url);
                
            $stmt = null;
        }
    }

}
