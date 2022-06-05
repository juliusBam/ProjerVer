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
    //die($d && $d->format("Y-m-d H:i:s") == $var);
}

function appendPostIt($queryOutput) {
    $resultSet = array();
    if (!is_array) {
        response("GET", 400, "Invalid parameter");
    }
    foreach($queryOutput as $row) {

        array_push($resultSet,new PostIt($row["postIt_ID"], $row["title"], $row["descr"],
                                                $row["postTimeStamp"], $row["deadline"], $row["createdBy_userID"],
                                                $row["creatorName"], $row["assignedTo_userID"], $row["assignedName"],
                                                $row["fk_priorityID"],$row["prioLabel"]));
                                                
    }

    return $resultSet;
}

?>