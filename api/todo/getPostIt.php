<?php

//TODO update the user class with the role id
//as well as the constructor

$dirUp = dirname(__DIR__, 2);

$userClass = $dirUp."/php/dataRequests/dataModels/postIt.class.php";
$dbClass = $dirUp."/php/classes/dbh.classes.php";

include_once($userClass);
include_once("../apiFunctions.php");

//accepts only get requests
checkRequestMethod("GET");

$postID = false;
$assignedID = false;
$creatorID = false;
$deadlinePast = false;
$deadlineFuture = false;

$resultSet = null;

(isset($_GET["postID"]) && isValidID($_GET["postID"])) ? $postID = $_GET["postID"] : $postID = false;
(isset($_GET["assignedID"]) && isValidID($_GET["assignedID"])) ? $neededId = $_GET["assignedID"] : $neededId = false;
(isset($_GET["creatorID"]) && isValidID($_GET["creatorID"])) ? $creatorID = $_GET["creatorID"] : $creatorID = false;
(isset($_GET["onlyPast"]) && isValidString($_GET["onlyPast"])) ? $deadlinePast = $_GET["onlyPast"] : $deadlinePast = false;
(isset($_GET["onlyFuture"]) && isValidString($_GET["onlyFuture"])) ? $deadlineFuture = $_GET["onlyFuture"] : $deadlineFuture = false;

//both deadline flags cannot be set
if ($deadlinePast && $deadlineFuture) {
    response("GET", 400, "Bad request");
}

$orderingClause = " ORDER BY deadline ASC, fk_priorityID ASC";

//connects to db
include_once("../apiDbConnection.php");

//returns 1 post with the given ID
if ($postID != false) {

        //$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $sql = "SELECT postIt_ID, title, descr, createdBy_userID, users.userName as creatorName, 
                            assignedTo_userID, u1.userName as assignedName, 
                            priorities.priorityLabel as prioLabel, 
                            deadline, postIt.creationTimeStamp as postTimeStamp, fk_priorityID, postStatus
                    FROM `postIt` 
                        JOIN
                            users on postIt.createdBy_userID = users.userID
                        JOIN
                            users u1 on postIt.assignedTo_userID = u1.userID
                        JOIN
                            priorities on postIt.fk_priorityID = priorities.priorityID
                    WHERE 
                        postIt_ID = :neededID";

        if ($deadlinePast) {
            $sql = $sql . " AND deadline < now()";
        } else if ($deadlineFuture) {
            $sql = $sql . " AND deadline > now()";
        }

        $sql = $sql . $orderingClause;

        $query = $db->prepare($sql);

        try {

            $query->bindParam("neededID", $postID, PDO::PARAM_INT);

            $query->execute();

            $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($queryRes) > 0) {
        
                //the result set has to become an array in order to push every found dataset into it
                $resultSet = array();
                $resultSet = appendPostIt($queryRes);
        
                /*foreach($queryRes as $row) {
        
                    array_push($resultSet,new PostIt($row["postIt_ID"], $row["title"], $row["descr"],
                                                            $row["postTimeStamp"], $row["deadline"], $row["createdBy_userID"],
                                                            $row["creatorName"], $row["assignedTo_userID"], $row["assignedName"],
                                                            $row["fk_priorityID"],$row["prioLabel"],$row["postStatus"]));
                                                            
                }*/

            }

            if ($resultSet == null) {
    
                response("GET", 200, "Empty");
        
            }

        } catch (\Throwable $th) {

            response("GET", 400, $th);
    
        } 


} else if ($assignedID != false) {
    //returns all the assigned post to the given userID

    $sql = "SELECT postIt_ID, title, descr, createdBy_userID, users.userName as creatorName, 
                    assignedTo_userID, u1.userName as assignedName, 
                    priorities.priorityLabel as prioLabel, 
                    deadline, postIt.creationTimeStamp as postTimeStamp, fk_priorityID, postStatus
                FROM `postIt` 
                JOIN
                    users on postIt.createdBy_userID = users.userID
                JOIN
                    users u1 on postIt.assignedTo_userID = u1.userID
                JOIN
                    priorities on postIt.fk_priorityID = priorities.priorityID
                WHERE assignedTo_userID = :neededId";

    if ($deadlinePast) {
        $sql = $sql . " AND deadline < now()";
    } else if ($deadlineFuture) {
        $sql = $sql . " AND deadline > now()";
    }

    $sql = $sql . $orderingClause;

    $query = $db->prepare($sql);

    try {

        $query->bindParam("neededId", $assignedID, PDO::PARAM_INT);

        $query->execute();

        $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);

        if (count($queryRes) > 0) {
    
            //the result set has to become an array in order to push every found dataset into it
            $resultSet = array();
            $resultSet = appendPostIt($queryRes);
        }
    
        if ($resultSet == null) {
    
            response("GET", 200, "Empty");
    
        }

    } catch (\Throwable $th) {

        response("GET", 400, $th);

    }

} else if ($creatorID != false) {
    //returns all the post created by the user, but not the self-assigned one, this will be in the assigned API

    $sql = "SELECT postIt_ID, title, descr, createdBy_userID, users.userName as creatorName, 
                    assignedTo_userID, u1.userName as assignedName, 
                    priorities.priorityLabel as prioLabel, 
                    deadline, postIt.creationTimeStamp as postTimeStamp, fk_priorityID, postStatus
                FROM `postIt` 
                JOIN
                    users on postIt.createdBy_userID = users.userID
                JOIN
                    users u1 on postIt.assignedTo_userID = u1.userID
                JOIN
                    priorities on postIt.fk_priorityID = priorities.priorityID
                WHERE createdBy_userID = :neededId AND createdBy_userID <> assignedTo_userID";

    if ($deadlinePast) {
        $sql = $sql . " AND deadline < now()";
    } else if ($deadlineFuture) {
        $sql = $sql . " AND deadline > now()";
    }

    $sql = $sql . $orderingClause;

    $query = $db->prepare($sql);

    try {

    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

        $query->bindParam("neededID", $postID, PDO::PARAM_INT);

        $query->execute();

        $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);

        if (count($queryRes) > 0) {
            
            //the result set has to become an array in order to push every found dataset into it
            $resultSet = array();
            $resultSet = appendPostIt($queryRes);

        }

        if ($resultSet == null) {

            response("GET", 200, "Empty");
    
        }

    } catch (\Throwable $th) {

        response("GET", 400, $th);

    } 


} else {

    //$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    $sql = "SELECT postIt_ID, title, descr, createdBy_userID, users.userName as creatorName, 
                    assignedTo_userID, u1.userName as assignedName, 
                    priorities.priorityLabel as prioLabel, 
                    deadline, postIt.creationTimeStamp as postTimeStamp, fk_priorityID, postStatus
                FROM `postIt` 
                JOIN
                    users on postIt.createdBy_userID = users.userID
                JOIN
                    users u1 on postIt.assignedTo_userID = u1.userID
                JOIN
                    priorities on postIt.fk_priorityID = priorities.priorityID";

    if ($deadlinePast) {
        $sql = $sql . " WHERE deadline < now()";
    } else if ($deadlineFuture) {
        $sql = $sql . " WHERE  deadline > now()";
    }

    $sql = $sql . $orderingClause;

    $query = $db->prepare($sql);

    $query->execute();

    //print_r($query->errorInfo());

    $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($queryRes) > 0) {
        //the result set has to become an array in order to push every found dataset into it
        $resultSet = array();
        $resultSet = appendPostIt($queryRes);

    }

    if ($resultSet == null) {

        $resultSet = "noPostit";

    }

}

switch ($resultSet) {

    case "noPostit":
        response("GET", 200, "Postit not found");
        break;
    case false:
        response("GET", 400, "An error occoured");
        break;
    case null:
        response("GET", 200, "Empty");
    default:
        response("GET", 200, $resultSet);
}

?>