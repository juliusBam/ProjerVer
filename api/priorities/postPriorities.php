<?php

include_once "../apiFunctions.php";

        //accepts only post requests
        checkRequestMethod("POST");

        //first we clean all the post variables from evil chars
        filter_var_array($_POST, FILTER_SANITIZE_STRING);

        $newLabel;

        //if label is not set and not valid the script returns an error
        (isset($_POST["label"]) && isValidString($_POST["label"])) ? $newLabel = $_POST["label"] : response("GET", 400, "Bad label");

        //connects to db
        include_once("../apiDbConnection.php");

        //the statement to execute
        $sql = "INSERT 
                    INTO  
                        priorities (priorityLabel) 
                    VALUES (:newLabel)";

        try {

            //preapres the sql
            $stmt = $db->prepare($sql);

            //binds the params and executes the stmt
            $stmt->bindParam("newLabel", $newLabel, PDO::PARAM_STR);
            
            $stmt->execute();

            response("GET", 200, "Success");


        } catch (\Throwable $th) {

            response("GET", 400, $th);

        }

?>