<?php

include_once "../apiFunctions.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        //first we clean all the post variables from evil chars
        filter_var_array($_POST, FILTER_SANITIZE_STRING);

        //we need the vars outside an array to bind them to the SQL
        $newUserName;
        $newFirstName;
        $newSecondName;
        $newEmail;
        $newGender;
        $newBirthDate;
        $newPwd;
        $newRoleID;
        
        //check the post of the vars
        (isset($_POST["username"]) && $_POST["username"] != "") ? $newUserName = $_POST["username"] : response("GET", 400, "Invalid username");

        (isset($_POST["firstName"]) && $_POST["firstName"] != "") ? $newFirstName = $_POST["firstName"] : response("GET", 400, "Invalid first name");

        response("GET", 200, "Okkey");
    } else {
        response("GET", 400, "Bad request");
    }

?>