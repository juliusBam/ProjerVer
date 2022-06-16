<?php

    class PostIt{
        public $id;
        public $title;
        public $description;
        public $createdOn;
        public $deadline;
        public $createdBy;
        public $createdByName;
        public $assignedTo;
        public $assignedToName;
        public $priorityID;
        public $priorityLabel;
        public $postStatus;

        public function __construct($newID, $newTitle, $newDesc, $newDate, 
                                        $newDeadline, $newCreator, $newCreatorName, $newAssigned, 
                                        $newAssignedName, $newPrio, $newPrioLabel, $newStatus) {

            $this->id = $newID;
            $this->title = $newTitle;
            $this->description = $newDesc;
            $this->createdOn = $newDate;
            $this->deadline = $newDeadline;
            $this->createdBy = $newCreator;
            $this->createdByName = $newCreatorName;
            $this->assignedTo = $newAssigned;
            $this->assignedToName = $newAssignedName;
            $this->priorityID = $newPrio;
            $this->priorityLabel = $newPrioLabel;
            $this->postStatus = $newStatus;

        }
    }

?>