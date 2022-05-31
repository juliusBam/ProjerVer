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
        (isset($_POST["createdBy"]) && isValidID($_POST["createdBy"])) ? $newCreator = $_POST["createdBy"] : response("GET", 400, "Bad user");

        (isset($_POST["title"]) && isValidString($_POST["title"])) ? $newTitle = $_POST["title"] : response("GET", 400, "Bad title");

        (isset($_POST["priority"]) && isValidID($_POST["priority"])) ? $newPriority = $_POST["priority"] : response("GET", 400, "Bad priority ID");

        (isset($_POST["assignedTo"]) && isValidID($_POST["assignedTo"])) ? $newAssigned = $_POST["assignedTo"] : response("GET", 400, "Bad assigned user");

        (isset($_POST["descr"]) && isValidString($_POST["descr"])) ? $newDescription = $_POST["descr"] : response("GET", 400, "Bad description");

        (isset($_POST["deadline"]) && isValidTimeStamp($_POST["deadline"])) ? $newDeadline = $_POST["deadline"] : response("GET", 400, "Bad deadline");

        //since the response function ends the script we reach this part only if all the inputs are valid

        //connects to db
        try {
            $db = new PDO('mysql:host=localhost;dbname=projerVer', "itProjektUser", "itProjektUser");
        }
        catch(PDOException $e) {
            response("GET", 400, "DB connection problem");
        }

        $sql = "INSERT INTO postIt
                    (title, descr, createdBy_userID, assignedTo_userID, fk_priorityID, deadline)
                    VALUES
                        (:newTitle, :newDescr, :newCreator, :newAssigned, :newPrio, :newDeadline)";
        try {

            $stmt = $db->prepare($sql);

            $stmt->bindParam("newTitle", $newTitle, PDO::PARAM_STR);
            $stmt->bindParam("newDescr", $newDescription, PDO::PARAM_STR);
            $stmt->bindParam("newCreator", $newCreator, PDO::PARAM_INT);
            $stmt->bindParam("newAssigned", $newAssigned, PDO::PARAM_INT);
            $stmt->bindParam("newPrio", $newPriority, PDO::PARAM_INT);
            $stmt->bindParam("newDeadline", $newDeadline, PDO::PARAM_STR);

            $stmt->execute();

            response("GET", 200, "Success");

        } catch (\Throwable $th) {

            response("GET", 400, $th);

        }

    } else {
        response("GET", 400, "Bad request");
    }

?>