<?php

class Dbh {

    protected function connect() {
        try {
            $username = "root";
            $password = "";
            // dbname has to be changed from -dummy- !
            $dbh = new PDO('mysql:host=localhost;dbname=dummy', $username, $password);
            return $dbh;
        } 
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

}