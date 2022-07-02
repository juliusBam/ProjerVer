<?php

include_once("../apiFunctions.php");

        //accepts only post requests
        checkRequestMethod("POST");

//checks the passed parameters
$postID = false;
$newStatus = false;
$userID = false;

$postIDtoChange = false;
$statusToAdd = false;

//check if the post id and the new status are passed as param
(isset($_POST["postID"]) && isValidID($_POST["postID"])) ? $postIDtoChange = $_POST["postID"] : response("GET", 400, "Invalid ID");
(isset($_POST["newStatus"]) && ($_POST["newStatus"] == 1 || $_POST["newStatus"] == 0)) ? $statusToAdd = $_POST["newStatus"] : response("GET", 400, "Invalid new status");
(isset($_POST["userID"]) && isValidID($_POST["userID"])) ? $userID = $_POST["userID"] : response("GET", 400, "Invalid user");

try {

    include_once("../apiDbConnection.php");

    //starts a transaction (we have to execute 2 sql after eachother)
    $db->beginTransaction();

    //the SQL to execute
    $sqlUpdate = "UPDATE postIt
                    SET postStatus = :newStatus
                    WHERE postIt_ID = :IDtoChange";

    $stmt = $db->prepare($sqlUpdate);

    //binds parameters
    $stmt->bindParam("newStatus", $statusToAdd, PDO::PARAM_INT);
    $stmt->bindParam("IDtoChange", $postIDtoChange, PDO::PARAM_INT);

    $stmt->execute();


    //inserts a log that the user userID closed a post it
    $sqlInsertLog = "INSERT INTO `logs`(fk_userID, fk_logType) VALUES (:userID,4)";

    $stmtLog = $db->prepare($sqlInsertLog);

    $stmtLog->bindParam("userID", $userID, PDO::PARAM_INT);

    $stmtLog->execute();

    //if everything went right commits the transaction

    $db->commit();
    response("GET", 200, "Okkey");

    //if error rollbacks the transaction and sends the exception
} catch (\Throwable $th) {

    $db->rollBack();

    response("GET", 400, $th);

}
