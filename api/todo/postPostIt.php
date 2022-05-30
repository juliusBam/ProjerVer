<?php

include_once "../apiFunctions.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        //first we clean all the post variables from evil chars
        filter_var_array($_POST, FILTER_SANITIZE_STRING);

        //we need the vars outside an array to bind them to the SQL
        $newCreator;
        $newTitle;
        $newPriority;
        $newAssigned;
        $newDescription;
        $newDeadline;
        
        //check the post of the vars
        (isset($_POST["createdBy"]) && isValidID($_POST["createdBy"])) ? $newCreator = $_POST["username"] : response("GET", 400, "Bad user");
  
        (isset($_POST["title"]) && isValidString($_POST["title"])) ? $newTitle = $_POST["title"] : response("GET", 400, "Bad title");

        (isset($_POST["priority"]) && isValidID($_POST["priority"])) ? $newPriority = $_POST["priority"] : response("GET", 400, "Bad priority ID");

        (isset($_POST["assignedTo"]) && isValidID($_POST["assignedTo"])) ? $newAssigned = $_POST["assignedTo"] : response("GET", 400, "Bad assigned user");

        (isset($_POST["descr"]) && isValidString($_POST["descr"])) ? $newDescription = $_POST["descr"] : response("GET", 400, "Bad description");

        //NOT WORKING! ##################################
        (isset($_POST["deadline"]) && isValidTimeStamp($_POST["deadline"])) ? $newDeadline = $_POST["deadline"] : response("GET", 400, "Bad deadline");

        response("GET", 200, "Okkey");
    } else {
        response("GET", 400, "Bad request");
    }

?>