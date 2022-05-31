<?php

    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $dirUp = dirname(__DIR__, 2);

        $userClass = $dirUp."/php/dataRequests/dataModels/role.class.php";
        $dbClass = $dirUp."/php/classes/dbh.classes.php";

        include_once($userClass);
        include_once("../apiFunctions.php");

        try {
            $db = new PDO('mysql:host=localhost;dbname=projerVer', "itProjektUser", "itProjektUser");
        }
        catch(PDOException $e) {
            response("GET", 400, "DB connection problem");
        }

        $resultSet;

        try {

            $resultSet = array();

            if (isset($_GET["id"]) && isValidID($_GET["id"])) {

                $searchedRole = $_GET["id"];

                $sql = "SELECT * 
                            FROM 
                                roles
                            WHERE
                                roleID = :newRole";
                
                $stmt = $db->prepare($sql);

                $stmt->bindParam("newRole", $searchedRole, PDO::PARAM_INT);

                $stmt->execute();

                $queryRes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                array_push($resultSet, new Role($queryRes["roleID"], $queryRes["roleLabel"]));
    
            } else {

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

    } else {

        response("GET", 400, "Bad request");

    }

?>