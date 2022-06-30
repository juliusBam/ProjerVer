<?php

    class DayStat{

        public $date;
        public $label;
        public $numbLogins;
        public $numbCreatedPosts;
        public $numbClosedPosts;
        public $numbCreatedUsers;
        
        public function __construct($newDate, $newNumbLogins, $newNumbCreatedPosts,
                                        $newNumbClosedPosts, $newNumbCreatedUsers) {
                                            
            $this->date = $newDate;
            $this->label = "Logs of: " . $newDate;
            $this->numbLogins = $newNumbLogins;
            $this->numbCreatedPosts = $newNumbCreatedPosts;
            $this->numbClosedPosts = $newNumbClosedPosts;
            $this->numbCreatedUsers = $newNumbCreatedUsers;

        }

    }

?>