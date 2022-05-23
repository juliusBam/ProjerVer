<?php

    include_once "dataModels/postIt.class.php";
    include_once "dataModels/user.class.php";

    class ResultSet {

        public function __construct() {

        }

        public function getAllPosts() {

            //WILL become a SQL
            $fileContent = file_get_contents("../../json/dummyToDo.json");
            $fileConentJson = json_decode($fileContent);
            //var_dump($fileConentJson);
            $result;
            //the objects are created with the same id
            foreach ($fileConentJson as $key => $value) {
               $result[$key] = new PostIt(1, $value->title, $value->desc, $value->creationDate, "Deadline",
                                            $value->createdBy, $value->assignedTo, $value->priority);
            }

            return $result;
        
        }

        public function getAllUsers() {

            //WILL become a SQL

            //gets the data from file
            $fileContent = file_get_contents("../../json/dummyLogin.json");
            $fileConentJson = json_decode($fileContent);
            //var_dump($fileConentJson);
            $result;
            //the objects are created with the same id
            foreach ($fileConentJson as $key => $value) {
               $result[$key] = new UserData($value->uName, "First name", "Second name", "gender",
                                            "Birthdate", $value->email, $value->type, $value->createdOn);
                //$i++;
            }

            return $result;

        }

        public function getAllPostsUser($uName) {

            //WILL become a SQL-->db Class

            $fileContent = file_get_contents("../../json/dummyToDo.json");
            $fileConentJson = json_decode($fileContent);
            //var_dump($fileConentJson);
            $result;
            //the objects are created with the same id
            foreach ($fileConentJson as $key => $value) {
                if ($value->createdBy == $uName) {
                    $result[$key] = new PostIt(1, $value->title, $value->desc, $value->creationDate,
                                        $value->createdBy, $value->assignedTo, $value->priority);
                }
            }

            return $result;

        }

        public function getAllPostsForUser($uName) {

            //WILL become a SQL-->db Class

            $fileContent = file_get_contents("../../json/dummyToDo.json");
            $fileConentJson = json_decode($fileContent);
            //var_dump($fileConentJson);
            $result;
            //the objects are created with the same id
            foreach ($fileConentJson as $key => $value) {
                if ($value->assignedTo == $uName) {
                    $result[$key] = new PostIt(1, $value->title, $value->desc, $value->creationDate,
                                        $value->createdBy, $value->assignedTo, $value->priority);
                }
            }

            return $result;

        }
    }
?>