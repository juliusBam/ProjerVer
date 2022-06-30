<?php

$dirUp = dirname(__DIR__, 2);

$dailyClass = $dirUp."/php/dataRequests/dataModels/stats/dailyStats.class.php";
//$dbClass = $dirUp."/php/classes/dbh.classes.php";

include_once($dailyClass);
include_once("../apiFunctions.php");

checkRequestMethod("GET");

$requestedDay = false;
$resultSet;

(isset($_GET["day"]) && isValidDate($_GET["day"])) ? $requestedDay = $_GET["day"] : $requestedDay = (new DateTime())->format("Y-m-d");


try {

    include_once("../apiDbConnection.php");

    //date format has to be in YYYY-MM-DD

        //we count the logIns and store the res logType = 2 is login
        $sqlLogIns = "SELECT count(logID) 
                        FROM logs 
                            WHERE fk_logType = 2 AND date(timeStamp) = date(:myDate);";
        
        $stmtLogIns = $db->prepare($sqlLogIns);

        $stmtLogIns->bindParam("myDate", $requestedDay, PDO::PARAM_STR);

        $stmtLogIns->execute();

        $resLogins = $stmtLogIns->fetch(PDO::FETCH_ASSOC);
        $numbLogins = $resLogins["count(logID)"];
        
        //then we count the created posts and the store the res
        $sqlCreatedPost = "SELECT count(postIt_ID) 
                        FROM postIt 
                            WHERE date(creationTimeStamp) = date(:myDate)"; 

        $stmtCreatedPost = $db->prepare($sqlCreatedPost);
        $stmtCreatedPost->bindParam("myDate", $requestedDay, PDO::PARAM_STR);

        $stmtCreatedPost->execute();

        $resCreatedPost = $stmtCreatedPost->fetch(PDO::FETCH_ASSOC);
        $numbCreatedPost = $resCreatedPost["count(postIt_ID)"];

        //now we retrieve the number of closed posts
        //we count the sqlClosedPosts and store the res logType = 4 is close post
        $sqlClosedPosts = "SELECT count(logID) 
                        FROM logs 
                            WHERE fk_logType = 4 AND date(timeStamp) = date(:myDate);";

        $stmtClosedPosts = $db->prepare($sqlClosedPosts);
        $stmtClosedPosts->bindParam("myDate", $requestedDay, PDO::PARAM_STR);

        $stmtClosedPosts->execute();

        $resClosedPosts = $stmtClosedPosts->fetch(PDO::FETCH_ASSOC);
        $numbClosedPosts = $resClosedPosts["count(logID)"];

        //now we count the number of created users
        $sqlCreatedUsers = "SELECT count(userID) 
                                FROM users 
                                WHERE date(creationTimeStamp) = date(:myDate);";

        $stmtCreatedUsers = $db->prepare($sqlCreatedUsers);
        $stmtCreatedUsers->bindParam("myDate", $requestedDay, PDO::PARAM_STR);

        $stmtCreatedUsers->execute();

        $resCreatedUsers = $stmtCreatedUsers->fetch(PDO::FETCH_ASSOC);
        $numbCreatedUsers = $resCreatedUsers["count(userID)"];
        $dailyStats = new DayStat($requestedDay, $numbLogins, $numbCreatedPost, $numbClosedPosts, $numbCreatedUsers);

        response("GET", 201, $dailyStats);

} catch (\Throwable $th) {

    response("GET", 400, $th);

}

?>