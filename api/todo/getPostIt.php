<?php

//goes 2 dir up
$dirUp = dirname(__DIR__, 2);

//creates the path to the data model
$userClass = $dirUp."/php/dataRequests/dataModels/postIt.class.php";

//includes the data model and the helper functions
include_once($userClass);
include_once("../apiFunctions.php");

//accepts only get requests
checkRequestMethod("GET");

//sets the variables for the params
$postID = false;
$assignedID = false;
$creatorID = false;
$deadlinePast = false;
$deadlineFuture = false;

$resultSet = null;

//checks which params are set and valid
(isset($_GET["postID"]) && isValidID($_GET["postID"])) ? $postID = $_GET["postID"] : $postID = false;
(isset($_GET["assignedID"]) && isValidID($_GET["assignedID"])) ? $assignedID = $_GET["assignedID"] : $assignedID = false;
(isset($_GET["creatorID"]) && isValidID($_GET["creatorID"])) ? $creatorID = $_GET["creatorID"] : $creatorID = false;
(isset($_GET["onlyPast"]) && isValidString($_GET["onlyPast"])) ? $deadlinePast = $_GET["onlyPast"] : $deadlinePast = false;
(isset($_GET["onlyFuture"]) && isValidString($_GET["onlyFuture"])) ? $deadlineFuture = $_GET["onlyFuture"] : $deadlineFuture = false;

//both deadline flags cannot be set
if ($deadlinePast && $deadlineFuture) {
    response("GET", 400, "Bad request");
}

//ordering clause will be appended at the end of the sql
$orderingClause = " ORDER BY deadline ASC, fk_priorityID ASC";

try {

    //connects to db
    include_once("../apiDbConnection.php");

    //returns 1 post with the given ID
    if ($postID != false) {

            //creates the sql
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

            //appends deadline filter if needed
            if ($deadlinePast) {
                $sql = $sql . " AND deadline < now()";
            } else if ($deadlineFuture) {
                $sql = $sql . " AND deadline > now()";
            }

            //appends the ordering clause
            $sql = $sql . $orderingClause;

            $query = $db->prepare($sql);

            try {

                //binds the param, executes the sql and encapsulates the results into an object, if a result is found
                $query->bindParam("neededID", $postID, PDO::PARAM_INT);

                $query->execute();

                $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);

                if (count($queryRes) > 0) {
            
                    //the result set has to become an array in order to push every found dataset into it
                    $resultSet = array();
                    $resultSet = appendPostIt($queryRes);

                }

                //if no result returns empty
                if ($resultSet == null) {
        
                    response("GET", 200, "Empty");
            
                }

            } catch (\Throwable $th) {

                response("GET", 400, $th);
        
            } 


    //assignedID was set and valid
    } else if ($assignedID != false) {
        //returns all the assigned post to the given userID

        //creates sql, appends the deadline filter and appends the ordering clause

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

        //prepares the sql
        $query = $db->prepare($sql);

        try {
            //binds the params and executes

            $query->bindParam("neededId", $assignedID, PDO::PARAM_INT);

            $query->execute();

            $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);

            //encapsulates the results and push them into the result array
            if (count($queryRes) > 0) {
        
                //the result set has to become an array in order to push every found dataset into it
                $resultSet = array();
                $resultSet = appendPostIt($queryRes);
            }
        
            //if no resultSet sends empty
            if ($resultSet == null) {
        
                response("GET", 200, "Empty");
        
            }

        } catch (\Throwable $th) {

            response("GET", 400, $th);

        }

    } else if ($creatorID != false) {
        //returns all the post created by the user, but not the self-assigned one, this will be in the assigned API

        //creates sql, appends the deadline filter and the ordering clause

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
                    WHERE createdBy_userID = :neededId AND createdBy_userID <> assignedTo_userID ";

        if ($deadlinePast) {
            $sql = $sql . " AND deadline < now() ";
        } else if ($deadlineFuture) {
            $sql = $sql . " AND deadline > now() ";
        }

        $sql = $sql . $orderingClause;

        //prepares sql
        $query = $db->prepare($sql);

        try {

            //binds param and executes

            $query->bindParam("neededId", $creatorID, PDO::PARAM_INT);

            $query->execute();

            $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);

            //encapsulates the results and push them into the result array

            if (count($queryRes) > 0) {
                
                //the result set has to become an array in order to push every found dataset into it
                $resultSet = array();
                $resultSet = appendPostIt($queryRes);

            }

            //if no resultSet sends empty
            if ($resultSet == null) {

                response("GET", 200, "Empty");
        
            }

        } catch (\Throwable $th) {

            response("GET", 400, $th);

        } 


    } else {
        //in this case just returns ALL postITs

        //creates sql, appends the deadline filter and the ordering
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

        //prepares and executes the sql

        $query = $db->prepare($sql);

        $query->execute();

        $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);

        //if there is a result set it is encapsulated and pushed into the $resultSet array
        if (count($queryRes) > 0) {
            //the result set has to become an array in order to push every found dataset into it
            $resultSet = array();
            $resultSet = appendPostIt($queryRes);

        }

        //if no results returns "post it not found
        if ($resultSet == null) {

            response("GET", 200, "Postit not found");

        }

    }

    switch ($resultSet) {

        case false:
            response("GET", 400, "An error occoured");
            break;
        case null:
            response("GET", 200, "Empty");
        default:
            response("GET", 200, $resultSet);
    }

} catch (\Throwable $th) {

    response("GET", 400, $th);

}

?>