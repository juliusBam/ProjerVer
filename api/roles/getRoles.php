<?php

$dirUp = dirname(__DIR__, 2);

$userClass = $dirUp."/php/dataRequests/dataModels/role.class.php";
$dbClass = $dirUp."/php/classes/dbh.classes.php";

include_once($userClass);
include_once("../apiFunctions.php");

        //accepts only get requests
        checkRequestMethod("GET");

        //connects to db
        include_once("../apiDbConnection.php");

        $resultSet;

        try {

            if (isset($_GET["id"]) && isValidID($_GET["id"])) {

                $searchedRole = $_GET["id"];

                $sql = "SELECT * 
                            FROM 
                                roles
                            WHERE
                                roleID = :newRole LIMIT 1;";
                
                $stmt = $db->prepare($sql);

                $stmt->bindParam("newRole", $searchedRole, PDO::PARAM_INT);

                $stmt->execute();

                $queryRes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //var_dump($queryRes);
                //die();

                $resultSet = new Role($queryRes[0]["roleID"], $queryRes[0]["roleLabel"]);
    
            } else {

                $resultSet = array();

                $sql = "SELECT * FROM roles";
                
                $stmt = $db->prepare($sql);

                $stmt->execute();

                $queryRes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($queryRes != null) {

                    foreach($queryRes as $row) {

                        array_push($resultSet, new Role($row["roleID"], $row["roleLabel"]));

                    }

                }

            }

            response("GET", 200, $resultSet);

        }
        catch (\Throwable $th) {

            response("GET", 400, $th);

        }

?>