<?php

    class UserData{
        public $uID;
        public $uName;
        public $firstName;
        public $secondName;
        public $gender;
        public $birthdate;
        public $email;
        public $type;
        public $createdOn;

        public function __construct($newUserID, $newUserName, $newFirstName, $newSecondName, $newGender, $newBirthdate,
                                    $newEmail, $newType, $newCreatedOn) {
            $this->uID = $newUserID;
            $this->uName = $newUserName;
            $this->firstName = $newFirstName;
            $this->secondName = $newSecondName;
            $this->gender = $newGender;
            $this->birthdate = $newBirthdate;
            $this->email = $newEmail;
            $this->type = $newType;
            $this->createdOn = $newCreatedOn;
        }
    }

?>