<?php

$dirUp = dirname(__DIR__, 2);

//$userClass = $dirUp."/php/dataRequests/dataModels/postIt.class.php";
$dbClass = $dirUp."/php/classes/dbh.classes.php";

include_once($userClass);
include_once("../apiFunctions.php");

$postID = false;
$newStatus = false;

if ($_SERVER["REQUEST_METHOD"] != "PUT")
    response("GET", 400, "Bad request");

(isset($_POST["postID"]) && isValidID($_POST["postID"])) ? $postID = $_POST["postID"] : $postID = false;
(isset($_PUT["newStatus"]) && isValidID($_PUT["newStatus"])) ? $newStatus = $_PUT["newStatus"] : $newStatus = false;

var_dump($_PUT);
var_dump($_POST);
var_dump($postID);
var_dump($newStatus);