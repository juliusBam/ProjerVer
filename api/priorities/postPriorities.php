<?php

include_once "../apiFunctions.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        //first we clean all the post variables from evil chars
        filter_var_array($_POST, FILTER_SANITIZE_STRING);

        $newLabel;

        //if label is not set and not valid the script returns an error
        (isset($_POST["label"]) && isValidString($_POST["label"])) ? $newLabel = $_POST["label"] : response("GET", 400, "Bad label");

        //connects to db
        try {
            $db = new PDO('mysql:host=localhost;dbname=projerVer', "itProjektUser", "itProjektUser");
        }
        catch(PDOException $e) {
            response("GET", 400, "DB connection problem");
        }

        $sql = "INSERT 
                    INTO  
                        priorities (priorityLabel) 
                    VALUES (:newLabel)";

        try {

            $stmt = $db->prepare($sql);

            $stmt->bindParam("newLabel", $newLabel, PDO::PARAM_STR);
            
            $stmt->execute();

            response("GET", 200, "Success");


        } catch (\Throwable $th) {

            response("GET", 400, $th);

        }

    } else {

        response("GET", 400, "Bad request");

    }

?>