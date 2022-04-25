<?php

    class PostIt{
        public $id;
        public $title;
        public $descriptiion;
        public $createdOn;
        public $createdBy;
        public $assignedTo;
        public $priority;

        public function __construct($newID, $newTitle, $newDesc, $newDate, $newCreator, $newAssigned, $newPrio){
            $this->id = $newID;
            $this->title = $newTitle;
            $this->descriptiion = $newDesc;
            $this->createdOn = $newDate;
            $this->createdBy = $newCreator;
            $this->assignedTo = $newAssigned;
            $this->priority = $newPrio;
        }
    }

?>