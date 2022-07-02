<?php

//path 2  directories up
$dirUp = dirname(__DIR__, 2);

$dbClass = $dirUp."/php/classes/dbh.classes.php";

//include helper functions
include_once("../apiFunctions.php");

    //accepts only GET requests
    checkRequestMethod("GET");

    //checks and assigns the parameter $_GET["id"]
    $neededId = false;

    (isset($_GET["id"]) && isValidID($_GET["id"])) ? $neededId = $_GET["id"] : $neededId = false;


    //connects to db
    include_once("../apiDbConnection.php");

    //tries and catches possible excpetions
    try {

        //if the priority id is set
        if ($neededId) {

            //tries to delete the prio
            $query = $db->prepare("DELETE 
                                    FROM 
                                        priorities
                                    WHERE
                                        priorityID  =  :idToDel;");
    
            $query->bindParam(":idToDel", $neededId, PDO::PARAM_INT);

                //an exeption is thrown if the pk of the prio is present in a record, e.g. in a postIt
            $query->execute();

            response("GET", 200, "Deleted Priority");
        } else {        
                response("GET", 400, "Bad request");
        }
    
    } catch (\Throwable $th) {

        response("GET", 400, $th);

    } 


?>