<?php

//goes 2 dir up
$dirUp = dirname(__DIR__, 2);

//creates path to appropriate data model
$userClass = $dirUp."/php/dataRequests/dataModels/priority.class.php";

//includes data models and api functions
include_once($userClass);
include_once("../apiFunctions.php");

    //accepts only GET requests
    checkRequestMethod("GET");

    //checks which parameters are set and valid and assigns the value to the appropriate variables

    $neededId = false;

    $neededLabel = false;

    $resultSet = null;

    (isset($_GET["id"]) && isValidID($_GET["id"])) ? $neededId = $_GET["id"] : $neededId = false;
    (isset($_GET["label"]) && isValidString($_GET["label"])) ? $neededLabel = $_GET["label"] : $neededLabel = false;


    //connects to db
    include_once("../apiDbConnection.php");

    try {

        //if only neededid is set
        if ($neededId && !$neededLabel) {


            //retrieves the prio with the selected id
            $query = $db->prepare("SELECT * 
                                    FROM 
                                        priorities
                                    WHERE
                                        priorityID = :prioID LIMIT 1;");
    
            //binds passed parameter to placeholder in the SQL
            $query->bindParam("prioID", $neededId, PDO::PARAM_INT);

            //executes the SQL
            $query->execute();
    
            $queryRes = $query->fetch(PDO::FETCH_ASSOC);

            //capsulates the result in a Priority object and assigns it to the $resultSet
            if ($queryRes != null) {
    
                $resultSet = new Priority($queryRes["priorityID"], $queryRes["priorityLabel"]);
    
            } else if ($resultSet == null) {
    
                $resultSet = "noResult";
            
            }
    
        //if only label is set it fetches based upon the label
        } else if (!$neededId && $neededLabel) {
    
            //prepares the SQL
            $query = $db->prepare("SELECT * 
                                    FROM 
                                        priorities
                                    WHERE
                                        priorityLabel = :prioLabel LIMIT 1;");

            //bind the placeholder to the request param
            $query->bindParam("prioLabel", $neededLabel, PDO::PARAM_STR);
    
            $query->execute();
    
            $queryRes = $query->fetch(PDO::FETCH_ASSOC);

            //encapsulates the result and assigns it to $resultSet
            if ($queryRes != null) {
    
                $resultSet = new Priority($queryRes["priorityID"], $queryRes["priorityLabel"]);
    
            } else if ($resultSet == null) {
    
                $resultSet = "noResult";
            
            }
    
        //if both params or none is set 
        } else {
    
            //select all  the priorities
            $query = $db->prepare("SELECT * 
                                    FROM 
                                        priorities;");
    
            //executes the statement
            $query->execute();
    
            //fethces results
            $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);
    
            if ($queryRes != null) {
    
                //appends each resulting dataset encapsulated in a Priority object to $resultSet
                $resultSet = array();
    
                foreach($queryRes as $row) {
    
                    array_push($resultSet, new Priority($row["priorityID"], $row["priorityLabel"]));
                
                }
    
            } else if ($resultSet == null) {
    
                response("GET", 400, "Bad request");
            
            }
    
        }
    
        switch ($resultSet) {
    
            case "noResult":
                response("GET", 400, "Wrong id");
                break;
            case false:
                response("GET", 400, "An error occoured");
                break;
            case null:
                response("GET", 400, "Empty");
            default:
                response("GET", 200, $resultSet);
        }

    } catch (\Throwable $th) {

        response("GET", 400, $th);

    } 


?>