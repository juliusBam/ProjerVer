<?php
// establish a connection to the database
class Dbh {

    // simple method that will connect to the database
    protected function connect() {
        // check if a connection can be established, if not, run error message
        try {
            $username = "itProjektUser";
            $password = "itProjektUser";
            // run the connection with phpmyadmin
            $dbh = new PDO('mysql:host=localhost;dbname=projerVer', $username, $password);
            // if all values are correct, run the database handler
            return $dbh;
        } 
        // if we cannot connect to the databse, run the error message and die()
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

}
?>
