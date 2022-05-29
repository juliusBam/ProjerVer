<?php

//TODO update the post it class to contain all the needed information
//TODO update the user class with the role id
//as well as the constructor

$dirUp = dirname(__DIR__, 2);

$userClass = $dirUp."/php/dataRequests/dataModels/postIt.class.php";
$dbClass = $dirUp."/php/classes/dbh.classes.php";

include_once($userClass);
include_once("../apiFunctions.php");

$neededId = false;

$resultSet = null;

(isset($_GET["id"]) && $_GET["id"] != "") ? $neededId = $_GET["id"] : $neededId = false;

try {
    $db = new PDO('mysql:host=localhost;dbname=projerVer', "itProjektUser", "itProjektUser");
}
catch(PDOException $e) {
    response("GET", 400, "DB connection problem");
}

if ($neededId != false) {

} else {

    //$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

    $query = $db->prepare("SELECT postIt_ID, title, descr, createdBy_userID, users.userName as creatorName, 
                                    assignedTo_userID, u1.userName as assignedName, 
                                    priorities.priorityLabel as prioLabel, 
                                    deadline, postIt.creationTimeStamp as postTimeStamp, fk_priorityID
	                        FROM `postIt` 
                                JOIN
                                    users on postIt.createdBy_userID = users.userID
                                JOIN
                                    users u1 on postIt.assignedTo_userID = u1.userID
                                JOIN
                                    priorities on postIt.fk_priorityID = priorities.priorityID;");

    $query->execute();

    //print_r($query->errorInfo());


    $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($queryRes) > 0) {

        //the result set has to become an array in order to push every found dataset into it
        $resultSet = array();

        foreach($queryRes as $row) {

            array_push($resultSet,new PostIt($row["postIt_ID"], $row["title"], $row["descr"],
                                                    $row["postTimeStamp"], $row["deadline"], $row["createdBy_userID"],
                                                    $row["creatorName"], $row["assignedTo_userID"], $row["assignedName"],
                                                    $row["fk_priorityID"],$row["prioLabel"]));
                                                    
        }
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