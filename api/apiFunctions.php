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
    }
}

function isValidID($var) {
    return ($var != "" && is_numeric($var) && $var != 0 && $var != "0" && $var != null && !empty($var));
}

function isValidString($var) {
    return ($var != "" && $var != null && !empty($var));
}

//NOT WORKING!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//##################################
function isValidTimeStamp($var) {
    $d = new DateTime($var, new DateTimeZone("UTC"));
    //$d = DateTime::createFromFormat("Y-M-D HH:mm:ss", $var);
    die($d);
    return $d && $d->format("Y-m-d H:i:s") == $var;
}

?>