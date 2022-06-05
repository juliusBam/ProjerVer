<?php

$dirUp = dirname(__DIR__, 2);

$userClass = $dirUp."/php/dataRequests/dataModels/priority.class.php";
$dbClass = $dirUp."/php/classes/dbh.classes.php";

include_once($userClass);
include_once("../apiFunctions.php");

    //accepts only GET requests
    checkRequestMethod("GET");

    $neededId = false;

    $neededLabel = false;

    $resultSet = null;

    (isset($_GET["id"]) && isValidID($_GET["id"])) ? $neededId = $_GET["id"] : $neededId = false;
    (isset($_GET["label"]) && isValidString($_GET["label"])) ? $neededLabel = $_GET["label"] : $neededLabel = false;



    try {
        $db = new PDO('mysql:host=localhost;dbname=projerVer', "itProjektUser", "itProjektUser");
    }
    catch(PDOException $e) {
        response("GET", 400, "DB connection problem");
    }

    try {

        if ($neededId && !$neededLabel) {


            $query = $db->prepare("SELECT * 
                                    FROM 
                                        priorities
                                    WHERE
                                        priorityID = :prioID LIMIT 1;");
    
    
    
            $query->bindParam("prioID", $neededId, PDO::PARAM_INT);
    
            $query->execute();
    
            $queryRes = $query->fetch(PDO::FETCH_ASSOC);
    
            if ($queryRes != null) {
    
                $resultSet = new Priority($queryRes["priorityID"], $queryRes["priorityLabel"]);
    
            } else if ($resultSet == null) {
    
                $resultSet = "noResult";
            
            }
    
        } else if (!$neededId && $neededLabel) {
    
    
            $query = $db->prepare("SELECT * 
                                    FROM 
                                        priorities
                                    WHERE
                                        priorityLabel = :prioLabel LIMIT 1;");
    
    
    
            $query->bindParam("prioLabel", $neededLabel, PDO::PARAM_STR);
    
            $query->execute();
    
            $queryRes = $query->fetch(PDO::FETCH_ASSOC);
    
            if ($queryRes != null) {
    
                $resultSet = new Priority($queryRes["priorityID"], $queryRes["priorityLabel"]);
    
            } else if ($resultSet == null) {
    
                $resultSet = "noResult";
            
            }
    
        } else {
    
            $query = $db->prepare("SELECT * 
                                    FROM 
                                        priorities;");
    
            $query->execute();
    
            $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);
    
            if ($queryRes != null) {
    
                $resultSet = array();
    
                foreach($queryRes as $row) {
    
                    //$resultSet = $row["priorityID"];
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