<?php

//goes 2 dir up
$dirUp = dirname(__DIR__, 2);

//creates the path to the data models
$userClass = $dirUp."/php/dataRequests/dataModels/role.class.php";

//includes the data models as well as the helper functions
include_once($userClass);
include_once("../apiFunctions.php");

        //accepts only get requests
        checkRequestMethod("GET");

        //connects to db
        include_once("../apiDbConnection.php");

        $resultSet;

        try {

            //checks the parameters, if it's set and valid
            if (isset($_GET["id"]) && isValidID($_GET["id"])) {

                $searchedRole = $_GET["id"];

                //executes query to retrieve the role with the needed id
                $sql = "SELECT * 
                            FROM 
                                roles
                            WHERE
                                roleID = :newRole LIMIT 1;";
                
                $stmt = $db->prepare($sql);

                $stmt->bindParam("newRole", $searchedRole, PDO::PARAM_INT);

                $stmt->execute();

                $queryRes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //encapsulates the result into an object and assigns it to the $resultSet

                $resultSet = new Role($queryRes[0]["roleID"], $queryRes[0]["roleLabel"]);
    
            //if param is not set or not valid returns all the roles
            } else {

                $resultSet = array();

                //executes query
                $sql = "SELECT * FROM roles";
                
                $stmt = $db->prepare($sql);

                $stmt->execute();

                //fetches the results, encapsulates them into an object and pushes them into the array $resultSet

                $queryRes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($queryRes != null) {

                    foreach($queryRes as $row) {

                        array_push($resultSet, new Role($row["roleID"], $row["roleLabel"]));

                    }

                }

            }

            //if everything was fine sends the results

            response("GET", 200, $resultSet);

        } //if exception is thrown returns it
        catch (\Throwable $th) {

            response("GET", 400, $th);

        }

?>