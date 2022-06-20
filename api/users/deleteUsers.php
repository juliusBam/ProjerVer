<?php

$dirUp = dirname(__DIR__, 2);

$userClass = $dirUp."/php/dataRequests/dataModels/user.class.php";
$dbClass = $dirUp."/php/classes/dbh.classes.php";

include_once($userClass);
include_once("../apiFunctions.php");

    //accepts only GET requests
    checkRequestMethod("GET");

    $neededId = false;

    (isset($_GET["id"]) && isValidID($_GET["id"])) ? $neededId = $_GET["id"] : $neededId = false;


    //connects to db
    include_once("../apiDbConnection.php");

    try {

        if ($neededId) {

            
            $query = $db->prepare("UPDATE  
                                        Users
                                    SET
                                        status = 0
                                    WHERE
                                        userID  =  $neededId;");
    
            $query->execute();

            response("GET", 200, "Deleted user");
        } else {        
                response("GET", 400, "Bad request");
        }
    


    } catch (\Throwable $th) {

        response("GET", 400, $th);

    } 


?>