<?php

$dirUp = dirname(__DIR__, 2);

$dbClass = $dirUp."/php/classes/dbh.classes.php";

include_once("../apiFunctions.php");

$postID = false;
$newStatus = false;
$userID = false;

if ($_SERVER["REQUEST_METHOD"] != "POST")
    response("GET", 400, "Bad request");

$postIDtoChange = false;
$statusToAdd = false;

//check if the post id and the new status are passed as param
(isset($_POST["postID"]) && isValidID($_POST["postID"])) ? $postIDtoChange = $_POST["postID"] : response("GET", 400, "Invalid ID");
(isset($_POST["newStatus"]) && ($_POST["newStatus"] == 1 || $_POST["newStatus"] == 0)) ? $statusToAdd = $_POST["newStatus"] : response("GET", 400, "Invalid new status");
(isset($_POST["userID"]) && isValidID($_POST["userID"])) ? $userID = $_POST["userID"] : response("GET", 400, "Invalid user");

try {

    //when the 
    include_once("../apiDbConnection.php");

    $db->beginTransaction();

    //the SQL to execute
    $sqlUpdate = "UPDATE postIt
                    SET postStatus = :newStatus
                    WHERE postIt_ID = :IDtoChange";

    $stmt = $db->prepare($sqlUpdate);

    $stmt->bindParam("newStatus", $statusToAdd, PDO::PARAM_INT);
    $stmt->bindParam("IDtoChange", $postIDtoChange, PDO::PARAM_INT);

    $stmt->execute();

    $sqlInsertLog = "INSERT INTO `logs`(fk_userID, fk_logType) VALUES (:userID,4)";

    $stmtLog = $db->prepare($sqlInsertLog);

    $stmtLog->bindParam("userID", $userID, PDO::PARAM_INT);

    $stmtLog->execute();

    $db->commit();

} catch (\Throwable $th) {

    $db->rollBack();

    response("GET", 400, $th);

}

response("GET", 200, "Okkey");