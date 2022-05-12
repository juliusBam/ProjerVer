<?php
    //TODO script to sort the requests
    //TODO Add the data models to the classe
    include_once "resultSet.class.php";
    include_once "dataModels/postIt.class.php";
    include_once "dataModels/user.class.php";

    function response($method, $httpStatus, $data)
    {
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

    $param;
    $action = (isset($_GET["requesting"])) ? $_GET["requesting"] : false;

    if (isset($_GET["neededParam"]) && $_GET["neededParam"] == "y") {
        $param["id"] = isset($_GET["id"]) ? $_GET["id"] : false;
    }

    $result;
    
    //switch case if there are params defined
    if ($action && !empty($param)) {
        switch ($action) {
            case "getPostsByUserID":
                $resultSet = new ResultSet();
                $result = $resultSet->getAllPostsUser($param["id"]);
                unset($resultSet);
                break;
        }

    } else if ($action) {
        switch ($action) {
            case "getAllPosts":
                //gets the data from file
                $resultSet = new ResultSet();
                $result = $resultSet->getAllPosts();
                unset($resultSet);
                break;
            case "getAllUsers":
                $resultSet = new ResultSet();
                $result = $resultSet->getAllUsers();
                unset($resultSet);
                break;
        }
    }

    if ($result == null) {
        response("GET", 400, null);
    } else {
        response("GET", 200, $result);
    }


?>