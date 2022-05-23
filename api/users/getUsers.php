<?php

//TODO update the post it class to contain all the needed information
//TODO update the user class with the role id
//as well as the constructor

$dirUp = dirname(__DIR__, 2);

$userClass = $dirUp."/php/dataRequests/dataModels/user.class.php";
$dbClass = $dirUp."/php/classes/dbh.classes.php";

include_once($userClass);
include_once("../apiFunctions.php");

$neededId = false;

$neededPwd = false;

$resultSet = null;

(isset($_GET["id"]) && $_GET["id"] != "") ? $neededId = $_GET["id"] : $neededId = false;

(isset($_GET["pwd"]) && $_GET["pwd"] != "") ? $neededPwd = $_GET["pwd"] : $neededPwd = false;

try {
    $db = new PDO('mysql:host=localhost;dbname=projerVer', "itProjektUser", "itProjektUser");
}
catch(PDOException $e) {
    response("GET", 400, "DB connection problem");
}


if ($neededId && $neededPwd) {

    //$pwdToSearchFor = md5($neededPwd);

    $pwdToSearchFor = $neededPwd;

    $query = $db->prepare("SELECT * 
	                        FROM users 
                                JOIN 
    	                            roles on users.fk_roleID = roles.roleID
                            WHERE
    	                        userID = :uID AND pwd = :hashPwd 
                            LIMIT 1");

    $query->bindParam("uID", $neededId, PDO::PARAM_INT);
    $query->bindParam("hashPwd", $pwdToSearchFor, PDO::PARAM_STR);


    $query->execute();

    $queryRes = $query->fetch();

    if ($queryRes != null) {

        $resultSet = new UserData($queryRes["userName"], $queryRes["firstName"], $queryRes["secondName"],
                                    $queryRes["gender"], $queryRes["birthdate"], $queryRes["userEmail"],
                                    $queryRes["roleLabel"], $queryRes["creationTimeStamp"]);

    }

    if ($resultSet == null) {

        $resultSet = "Wrong inputs";
    
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

        $resultSet = new UserData($queryRes["userName"], $queryRes["firstName"], $queryRes["secondName"],
                                    $queryRes["gender"], $queryRes["birthdate"], $queryRes["userEmail"],
                                    $queryRes["roleLabel"], $queryRes["creationTimeStamp"]);

    }

    if ($resultSet == null) {

        $resultSet = "User not found";

    }


} else {

    $query = $db->prepare("SELECT * 
                            FROM users 
                                JOIN 
                                    roles on users.fk_roleID = roles.roleID");
    
    $query->execute();
    $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($queryRes) > 0) {

        //the result set has to become an array in order to push every found dataset into it
        $resultSet = array();

        foreach($queryRes as $row) {

            array_push($resultSet,new UserData($row["userName"], $row["firstName"], $row["secondName"],
                                                    $row["gender"], $row["birthdate"], $row["userEmail"],
                                                    $row["roleLabel"], $row["creationTimeStamp"]));
                                                    
        }
    }

    if ($resultSet == null) {

        $resultSet = "User not found";

    }

}

switch ($resultSet) {

    case "wrongPass":
        response("GET", 200, "Wrong password");
        break;
    case "noUser":
        response("GET", 200, "User not found");
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