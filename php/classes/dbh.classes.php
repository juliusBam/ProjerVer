<?php

class Dbh {

    protected function connect() {
        try {
            $username = "itProjektUser";
            $password = "itProjektUser";
            $dbh = new PDO('mysql:host=localhost;dbname=projerver', $username, $password);
            return $dbh;
        } 
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

}
?>

<!-- <?php 
//try {
//    $db = new PDO('mysql:host=localhost;dbname=projerVer', "itProjektUser", "itProjektUser");
//}
//catch(PDOException $e) {
//    response("GET", 400, "DB connection problem");
//}
?> -->