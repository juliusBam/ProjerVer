<?php

//goes 2 dir up
$dirUp = dirname(__DIR__, 2);

//path to userClass
$userClass = $dirUp."/php/dataRequests/dataModels/role.class.php";
//$dbClass = $dirUp."/php/classes/dbh.classes.php";

//includes userClass and helper functions
include_once($userClass);
include_once("../apiFunctions.php");

    //accepts only GET requests
    checkRequestMethod("GET");

    //checks if id is set and valid

    $neededId = false;

    (isset($_GET["id"]) && isValidID($_GET["id"])) ? $neededId = $_GET["id"] : $neededId = false;


    //connects to db
    include_once("../apiDbConnection.php");

    try {

        //goes on only if the id is set
        if ($neededId) {
            
            //prepares the statement to delete record with id = $neededid
            $query = $db->prepare("DELETE 
                                    FROM 
                                        roles
                                    WHERE
                                        roleID  =  :neededID;");
    
            $query->bindParam("neededID", $neededId, PDO::PARAM_INT);
    
            //executes statement
            $query->execute();

            response("GET", 200, "Deleted Role");
        } else {        
                response("GET", 400, "Bad request");
        }
    

        //if record cannot be deleted or other errors occour
    } catch (\Throwable $th) {

        response("GET", 400, $th);

    } 


?>