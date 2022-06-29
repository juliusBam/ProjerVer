<?php

    class TimeFrameStat{

        public $dateBegin;
        public $dateEnd;
        public $label;
        public $numbLogins;
        public $numbCreatedPosts;
        public $numbClosedPosts;
        public $numbCreatedUsers;
        
        public function __construct($newDate1, $newDate2, $newNumbLogins, $newNumbCreatedPosts,
                                        $newNumbClosedPosts, $newNumbCreatedUsers) {

            $this->dateBegin = $newDate1;
            $this->dateEnd = $newDate2;
            $this->label = "Logs from: " . $newDate1 . " to: " . $newDate2;
            $this->numbLogins = $newNumbLogins;
            $this->numbCreatedPosts = $newNumbCreatedPosts;
            $this->numbClosedPosts = $newNumbClosedPosts;
            $this->numbCreatedUsers = $newNumbCreatedUsers;

        }

    }

?>