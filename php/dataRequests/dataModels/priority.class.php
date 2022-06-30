<?php

    class Priority{
        
        public $id;
        public $label;

        public function __construct($newID, $newLabel) {

            $this->id = $newID;
            $this->label = $newLabel;

        }

    }

?>