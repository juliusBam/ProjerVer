<?php

//gets the path 2 directories up
$dirUp = dirname(__DIR__, 2);

//creates the path to the user class model
$userClass = $dirUp."/php/dataRequests/dataModels/user.class.php";

//includes helper functions and user class
include_once($userClass);
include_once("../apiFunctions.php");

    //accepts only GET requests
    checkRequestMethod("GET");

    //the passed parameter is checked, if not valid returns error 400
    $neededId = false;

    (isset($_GET["id"]) && isValidID($_GET["id"])) ? $neededId = $_GET["id"] : response("GET", 400, "Bad request");


    //connects to db
    include_once("../apiDbConnection.php");

    try {

        if ($neededId) {

            //prepares the SQL
            $query = $db->prepare("UPDATE  
                                        users
                                    SET
                                        status = 0
                                    WHERE
                                        userID  =  :idToDelete;");

            //binds the passed id to the placeholder
            $query->bindParam(":idToDelete",$neededId,PDO::PARAM_INT);
    
            $query->execute();

            response("GET", 200, "Deleted user");
        } else {        
                response("GET", 400, "Bad request");
        }
    

        //if an exception is thrown we send it to the client side
    } catch (\Throwable $th) {

        response("GET", 400, $th);

    } 


?>