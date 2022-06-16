<?php

include_once "../apiFunctions.php";
    //accept only POST requests
    checkRequestMethod("POST");
    
    //first we clean all the post variables from evil chars
    filter_var_array($_POST, FILTER_SANITIZE_STRING);
    
    //we need the vars outside an array to bind them to the SQL
    $newUserName;
    $newFirstName;
    $newSecondName;
    $newEmail;
    $newGender;
    $newBirthDate;
    $pwd1;
    $pwd2;
    $newPwd;
    $newRoleID;
    
    //check the post of the vars
    (isset($_POST["username"]) && isValidString($_POST["username"])) ? $newUserName = $_POST["username"] : response("GET", 400, "Invalid username");
    (isset($_POST["firstName"]) && isValidString($_POST["firstName"])) ? $newFirstName = $_POST["firstName"] : response("GET", 400, "Invalid first name");
    (isset($_POST["secondName"]) && isValidString($_POST["secondName"])) ? $newSecondName = $_POST["secondName"] : response("GET", 400, "Invalid second name");
    (isset($_POST["email"]) && isValidString($_POST["email"]) && isValidEmail($_POST["email"])) ? $newEmail = $_POST["email"] : response("GET", 400, "Invalid email");
    (isset($_POST["gender"]) && isValidString($_POST["gender"]) && strlen($_POST["gender"]) == 1) ? $newGender = $_POST["gender"] : response("GET", 400, "Invalid gender");
    (isset($_POST["birthDate"]) && isValidDate($_POST["birthDate"])) ? $newBirthDate = $_POST["birthDate"] : response("GET", 400, "Invalid birthdate");
    (isset($_POST["pwd1"]) && isValidPwd($_POST["pwd1"])) ? $pwd1 = $_POST["pwd1"] : response("GET", 400, "Invalid password 1");
    (isset($_POST["pwd2"]) && isValidPwd($_POST["pwd2"])) ? $pwd2 = $_POST["pwd2"] : response("GET", 400, "Invalid password 2");
    ($pwd1 == $pwd2) ? $newPwd = md5($pwd1) : response("GET", 400, "Password aren't matching");
    (isset($_POST["roleID"]) && isValidID($_POST["roleID"])) ? $newRoleID = $_POST["roleID"] : response("GET", 400, "Invalid role");

    try {

        include_once("../apiDbConnection.php");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //first we check if ther uName is unique, there are constraints in the db, but for usability we 
            //execute a select to check if the uName already exists in the db
        $queryCheckName = "SELECT userID
                                FROM users
                                WHERE userName = :myUserName";
        
        $stmtCheckName = $db->prepare($queryCheckName);
        $stmtCheckName->bindParam("myUserName", $newUserName, PDO::PARAM_STR);
        $stmtCheckName->execute();

        $resultCheckName = $stmtCheckName->fetchAll();

        //if username is not unique the script ends here and returns an error
        if(count($resultCheckName) != 0) {
            response("GET", 400, "Username is not unique");
        }
        
        //Now we check if the email is already present in the db
        $queryCheckEmail = "SELECT userID
                                FROM users
                                WHERE userEmail = :myUserEmail";

        $stmtCheckEmail = $db->prepare($queryCheckEmail);
        $stmtCheckEmail->bindParam("myUserEmail", $newEmail, PDO::PARAM_STR);
        $stmtCheckEmail->execute();
        
        $resultCheckEmail = $stmtCheckEmail->fetchAll();

        //if email is not unique the script ends here and returns an error
        if(count($resultCheckEmail) != 0) {
            response("GET", 400, "Email is not unique");
        }


        $queryAddUser = "INSERT 
                    INTO users 
                        (userName, firstName, secondName, userEmail, gender, birthdate, pwd, fk_roleID)
                     VALUES 
                        (:newUserName, :newFirstName, :newSecondName, :newEmail, :newGender, :newBirthdate, :newPwd, :newRole)";

        $smtAddUser = $db->prepare($queryAddUser);
        $smtAddUser->bindParam("newUserName", $newUserName, PDO::PARAM_STR);
        $smtAddUser->bindParam("newFirstName", $newFirstName, PDO::PARAM_STR);
        $smtAddUser->bindParam("newSecondName", $newSecondName, PDO::PARAM_STR);
        $smtAddUser->bindParam("newEmail", $newEmail, PDO::PARAM_STR);
        $smtAddUser->bindParam("newGender", $newGender, PDO::PARAM_STR);
        $smtAddUser->bindParam("newBirthdate", $newBirthDate, PDO::PARAM_STR);
        $smtAddUser->bindParam("newPwd", $newPwd, PDO::PARAM_STR);
        $smtAddUser->bindParam("newRole", $newRoleID, PDO::PARAM_INT);

        $smtAddUser->execute();

    } catch (\Throwable $th) {
        response("GET", 400, $th->getMessage());
    }

    response("GET", 200, "Okkey");

?>