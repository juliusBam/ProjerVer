<?php

function response($method, $httpStatus, $data) {
    header('Content-Type: application/json');
    switch ($method) {
        case "GET":
            http_response_code($httpStatus);
            echo (json_encode($data));
            break;
        default:
            http_response_code(405);
            echo ("Method not supported");
            break;
    }
    exit();
}

function isValidID($var) {
    return ($var != "" && is_numeric($var) && $var != 0 && $var != "0" && $var != null && !empty($var));
}

function isValidString($var) {
    //die($var);
    return ($var != "" && $var != null && !empty($var) && is_string($var));
}

function isValidTimeStamp($var) {
    $d = new DateTime($var);
    $timeStamp = new DateTime();
    $timeStamp->format("Y-m-d H:i:s");
    return ($d && $d > $timeStamp);
}

function isValidDate($dateString) {
    try {
        $d = new DateTime($dateString);
    } catch (\Throwable $th) {
        return false;
    }
    return ($d && $d < new DateTime());
}

function isValidEmail($emailString) {
    return filter_var($emailString, FILTER_VALIDATE_EMAIL);
}

function isValidPwd($pwdString) {
    //echo $pwdString;
    /*return (strlen($pwdString) > 8 && preg_match("#[0-9]+#", $pwdString)
                && preg_match("#[A-Z]+#", $pwdString) && preg_match("#[a-z]+#", $pwdString)
                && preg_match("/[!&_@#%^()<>?]+/", $pwdString));*/
    return true;
}

function checkRequestMethod($shouldBe) {
    if (!is_string($shouldBe)) {
        response("GET", 500, "Bad code");
    }
    if ($_SERVER["REQUEST_METHOD"] == $shouldBe) {
        return true;
    } else {
        response("GET", 400, "Bad method");
    }
}

function appendPostIt($queryOutput) {
    $resultSet = array();

    if (!is_array($queryOutput)) {
        response("GET", 400, "Invalid parameter");
    }
    foreach($queryOutput as $row) {

        array_push($resultSet,new PostIt($row["postIt_ID"], $row["title"], $row["descr"],
                                                $row["postTimeStamp"], $row["deadline"], $row["createdBy_userID"],
                                                $row["creatorName"], $row["assignedTo_userID"], $row["assignedName"],
                                                $row["fk_priorityID"],$row["prioLabel"], $row["postStatus"]));
                                                
    }

    return $resultSet;
}

?>