<?php

$dirUp = dirname(__DIR__, 2);


//creates the filepath to the user class
$userClass = $dirUp."/php/dataRequests/dataModels/user.class.php";


//includes user class and the helper functions
include_once($userClass);
include_once("../apiFunctions.php");

//accepts only get requests
checkRequestMethod("GET");

//these are the parameters which will be used to sort the type of query to execute
$neededId = false;

$neededPwd = false;

$neededName = false;

$resultSet = null;

$inactive = false;

$allUsers = false;

//checks if the parameters are valid, if yes they get the passed value

(isset($_GET["uName"]) && isValidString($_GET["uName"])) ? $neededName = $_GET["uName"] : $neededName = false;

(isset($_GET["id"]) && isValidID($_GET["id"])) ? $neededId = $_GET["id"] : $neededId = false;

(isset($_GET["pwd"]) && isValidString($_GET["pwd"])) ? $neededPwd = $_GET["pwd"] : $neededPwd = false;

(isset($_GET["inactive"]) && $_GET["inactive"] == "1") ? $inactive = true : $inactive = false;

(isset($_GET["allUsers"]) && $_GET["allUsers"] == "1") ? $allUsers = true : $allUsers = false;


//once the parameters are set we can go on with the data fetching
try {

    include_once("../apiDbConnection.php");
    //gets a user with a given uName and pwd
    if ($neededName && $neededPwd) {

        //hash the recieved pwd
        //$pwdToSearchFor = md5($neededPwd);
    
        $pwdToSearchFor = $neededPwd;
    
        //prepares query
        $query = $db->prepare("SELECT * 
                                FROM users 
                                    JOIN 
                                        roles on users.fk_roleID = roles.roleID
                                WHERE
                                    userName = :uID AND pwd = :hashPwd AND status = 1
                                LIMIT 1");
    
        //binds params
        $query->bindParam("uID", $neededName, PDO::PARAM_STR);

        $query->bindParam("hashPwd", $pwdToSearchFor, PDO::PARAM_STR);
    
        $query->execute();
    
        $queryRes = $query->fetch();
    
        //if we have a result set we encapsulate the data into $resultSet
        if ($queryRes != null) {
    
            $resultSet = new UserData($queryRes["userID"], $queryRes["userName"], $queryRes["firstName"], $queryRes["secondName"],
                                        $queryRes["gender"], $queryRes["birthdate"], $queryRes["userEmail"],
                                        $queryRes["roleLabel"], $queryRes["creationTimeStamp"], $queryRes["status"]);
    
        }
    //gets a user with a given id
    } else if ($neededId && $neededPwd == false) {
    
        //prepares the query
        $query = $db->prepare("SELECT * 
                                FROM users 
                                    JOIN 
                                        roles on users.fk_roleID = roles.roleID
                                WHERE
                                    userID = :uID
                                LIMIT 1");
    
        //assigns the param
        $query->bindParam("uID", $neededId, PDO::PARAM_INT);
        
        $query->execute();

        $queryRes = $query->fetch();
    
        //if we have a result set we encapsulate the data into $resultSet
        if ($queryRes != null) {
    
            $resultSet = new UserData($queryRes["userID"], $queryRes["userName"], $queryRes["firstName"], $queryRes["secondName"],
                                        $queryRes["gender"], $queryRes["birthdate"], $queryRes["userEmail"],
                                        $queryRes["roleLabel"], $queryRes["creationTimeStamp"], $queryRes["status"]);

        }
    //gets only inactive users
    } else if ($inactive) {

        //we prepare the query
        $query = $db->prepare("SELECT * 
                                FROM users 
                                    JOIN 
                                        roles on users.fk_roleID = roles.roleID
                                    WHERE status = 0");
        

        $query->execute();

        $queryRes = $query->fetchAll(PDO::FETCH_ASSOC);
    
        //if we have results
        if (count($queryRes) > 0) {
    
            //the result set has to become an array in order to push every found dataset into it
            $resultSet = array();
    
            foreach($queryRes as $row) {
    
                array_push($resultSet,new UserData($row["userID"], $row["userName"], $row["firstName"], $row["secondName"],
                                                        $row["gender"], $row["birthdate"], $row["userEmail"],
                                                        $row["roleLabel"], $row["creationTimeStamp"], $row["status"]));
                                                        
            }
        }

    //gets all users (active and inactive)
    } else if ($allUsers) {

        //prepares the query to execute 
            $query = $db->prepare("SELECT * 
                                    FROM users 
                                        JOIN roles on users.fk_roleID = roles.roleID");

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


    //gets all the active users
    } else {
    
        //prepares the query to execute 
        $query = $db->prepare("SELECT * 
                                FROM users 
                                    JOIN 
                                        roles on users.fk_roleID = roles.roleID
                                    ");
        
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

    //if an exception is thrown we catch it and send it client side
} catch (\Throwable $th) {

    response("GET", 400, $th);

}

//based upon the type of result set we have we send a different response
switch ($resultSet) {

    case null:
        response("GET", 200, "No users found");
        break;
    case false:
        response("GET", 400, "Bad request");
        break;
    default:
        response("GET", 200, $resultSet);
}

?>