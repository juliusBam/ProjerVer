<?php

$dirUp = dirname(__DIR__, 2);

$userClass = $dirUp."/php/dataRequests/dataModels/user.class.php";
$dbClass = $dirUp."/php/classes/dbh.classes.php";

include_once($userClass);
include_once("../apiFunctions.php");

//accepts only get requests
checkRequestMethod("GET");

$neededId = false;

$neededPwd = false;

$neededName = false;

$resultSet = null;

$inactive = false;

(isset($_GET["uName"]) && isValidString($_GET["uName"])) ? $neededName = $_GET["uName"] : $neededName = false;

(isset($_GET["id"]) && isValidID($_GET["id"])) ? $neededId = $_GET["id"] : $neededId = false;

(isset($_GET["pwd"]) && isValidString($_GET["pwd"])) ? $neededPwd = $_GET["pwd"] : $neededPwd = false;

(isset($_GET["inactive"]) && $_GET["inactive"] == "1") ? $inactive = true : $inactive = false;

include_once("../apiDbConnection.php");

try {

    if ($neededName && $neededPwd) {

        //$pwdToSearchFor = md5($neededPwd);
    
        $pwdToSearchFor = $neededPwd;
    
        $query = $db->prepare("SELECT * 
                                FROM users 
                                    JOIN 
                                        roles on users.fk_roleID = roles.roleID
                                WHERE
                                    userName = :uID AND pwd = :hashPwd AND status = 1
                                LIMIT 1");
    
        $query->bindParam("uID", $neededName, PDO::PARAM_STR);

        $query->bindParam("hashPwd", $pwdToSearchFor, PDO::PARAM_STR);
    
        $query->execute();
    
        $queryRes = $query->fetch();
    
        if ($queryRes != null) {
    
            $resultSet = new UserData($queryRes["userID"], $queryRes["userName"], $queryRes["firstName"], $queryRes["secondName"],
                                        $queryRes["gender"], $queryRes["birthdate"], $queryRes["userEmail"],
                                        $queryRes["roleLabel"], $queryRes["creationTimeStamp"], $queryRes["status"]);
    
        }
    
        if ($resultSet == null) {
    
            $resultSet = "wrongPass";
        
        }
    
    } else if ($neededId && $neededPwd == false) {
    
        $query = $db->prepare("SELECT * 
                                FROM users 
                                    JOIN 
                                        roles on users.fk_roleID = roles.roleID
                                WHERE
                                    userID = :uID
                                LIMIT 1");
    
        $query->bindParam("uID", $neededId, PDO::PARAM_INT);
        
        $query->execute();
        $queryRes = $query->fetch();
    
        if ($queryRes != null) {
    
            $resultSet = new UserData($queryRes["userID"], $queryRes["userName"], $queryRes["firstName"], $queryRes["secondName"],
                                        $queryRes["gender"], $queryRes["birthdate"], $queryRes["userEmail"],
                                        $queryRes["roleLabel"], $queryRes["creationTimeStamp"], $queryRes["status"]);

    
        }
    
    
    } else if ($inactive) {

        $query = $db->prepare("SELECT * 
                                FROM users 
                                    JOIN 
                                        roles on users.fk_roleID = roles.roleID
                                    WHERE status = 0");
        
        $query->execute();
        $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);
    
        if (count($queryRes) > 0) {
    
            //the result set has to become an array in order to push every found dataset into it
            $resultSet = array();
    
            foreach($queryRes as $row) {
    
                array_push($resultSet,new UserData($row["userID"], $row["userName"], $row["firstName"], $row["secondName"],
                                                        $row["gender"], $row["birthdate"], $row["userEmail"],
                                                        $row["roleLabel"], $row["creationTimeStamp"], $row["status"]));
                                                        
            }
        }


    } else {
    
        $query = $db->prepare("SELECT * 
                                FROM users 
                                    JOIN 
                                        roles on users.fk_roleID = roles.roleID
                                    WHERE status = 1");
        
        $query->execute();
        $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);
    
        if (count($queryRes) > 0) {
    
            //the result set has to become an array in order to push every found dataset into it
            $resultSet = array();
    
            foreach($queryRes as $row) {
    
                array_push($resultSet,new UserData($row["userID"], $row["userName"], $row["firstName"], $row["secondName"],
                                                        $row["gender"], $row["birthdate"], $row["userEmail"],
                                                        $row["roleLabel"], $row["creationTimeStamp"], $row["status"]));
                                                        
            }
        }
    
    }

} catch (\Throwable $th) {

    response("GET", 400, $th);

}

switch ($resultSet) {

    case "wrongPass":
        response("GET", 200, "Wrong password");
        break;
    case null:
        response("GET", 200, "No users found");
    case false:
        response("GET", 400, "Bad request");
    default:
        response("GET", 200, $resultSet);
}

?>