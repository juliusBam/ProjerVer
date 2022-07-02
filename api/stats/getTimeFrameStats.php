<?php

$dirUp = dirname(__DIR__, 2);

$timeFrameClass = $dirUp."/php/dataRequests/dataModels/stats/timeFrameStats.class.php";

include_once($timeFrameClass);
include_once("../apiFunctions.php");

checkRequestMethod("GET");

$requestedStart = false;
$requestedEnd = false;
$resultSet;

(isset($_GET["date1"]) && isValidAnyDate($_GET["date1"])) ? $requestedStart = $_GET["date1"] : response("GET", 400, "Invalid start date");
(isset($_GET["date2"]) && isValidAnyDate($_GET["date2"])) ? $requestedEnd = $_GET["date2"] : response("GET", 400, "Invalid end date");

try {
    include_once("../apiDbConnection.php");
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    //we count the logIns and store the res logType = 2 is login
    $sqlLogIns = "SELECT count(logID) 
                    FROM logs 
                        WHERE fk_logType = 2 AND date(timeStamp) BETWEEN date(:date1) AND date(:date2);";

    $stmtLogIns = $db->prepare($sqlLogIns);

    $stmtLogIns->bindParam("date1", $requestedStart, PDO::PARAM_STR);
    $stmtLogIns->bindParam("date2", $requestedEnd, PDO::PARAM_STR);

    $stmtLogIns->execute();

    $resLogins = $stmtLogIns->fetch(PDO::FETCH_ASSOC);
    $numbLogins = $resLogins["count(logID)"];

    //then we count the created posts and the store the res
    $sqlCreatedPost = "SELECT count(postIt_ID) 
                    FROM postIt 
                        WHERE date(creationTimeStamp) BETWEEN date(:date1) AND date(:date2);"; 

    $stmtCreatedPost = $db->prepare($sqlCreatedPost);

    $stmtCreatedPost->bindParam("date1", $requestedStart, PDO::PARAM_STR);
    $stmtCreatedPost->bindParam("date2", $requestedEnd, PDO::PARAM_STR);

    $stmtCreatedPost->execute();

    $resCreatedPost = $stmtCreatedPost->fetch(PDO::FETCH_ASSOC);
    $numbCreatedPosts = $resCreatedPost["count(postIt_ID)"];


    //now we retrieve the number of closed posts
    //we count the sqlClosedPosts and store the res logType = 4 is close post
    $sqlClosedPosts = "SELECT count(logID) 
                    FROM logs 
                        WHERE fk_logType = 4 AND date(timeStamp) BETWEEN date(:date1) AND date(:date2);";

    $stmtClosedPosts = $db->prepare($sqlClosedPosts);

    $stmtClosedPosts->bindParam("date1", $requestedStart, PDO::PARAM_STR);
    $stmtClosedPosts->bindParam("date2", $requestedEnd, PDO::PARAM_STR);

    $stmtClosedPosts->execute();

    $resClosedPosts = $stmtClosedPosts->fetch(PDO::FETCH_ASSOC);
    $numbClosedPosts = $resClosedPosts["count(logID)"];



    //now we count the number of created users
    $sqlCreatedUsers = "SELECT count(userID) 
                            FROM users 
                            WHERE date(creationTimeStamp) BETWEEN date(:date1) AND date(:date2);";

    $stmtCreatedUsers = $db->prepare($sqlCreatedUsers);

    $stmtCreatedUsers->bindParam("date1", $requestedStart, PDO::PARAM_STR);
    $stmtCreatedUsers->bindParam("date2", $requestedEnd, PDO::PARAM_STR);

    $stmtCreatedUsers->execute();

    $resCreatedUsers = $stmtCreatedUsers->fetch(PDO::FETCH_ASSOC);
    $numbCreatedUsers = $resCreatedUsers["count(userID)"];

    $timeStats = new TimeFrameStat($requestedStart, $requestedEnd, $numbLogins, $numbCreatedPosts, $numbClosedPosts, $numbCreatedUsers);

    response("GET", 201, $timeStats);

} catch (\Throwable $th) {

    response("GET", 400, $th);

}


?>