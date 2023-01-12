<?php
    require_once("connection.php");
    
    class User {
        private $_user_id;
        private $_first_name;
        private $_last_name;
        public $_email;
        public $_username;
        private $_password;
        private $_date_created;

        public function __construct($user_id, $first_name, $last_name, $email, $username, $password, $date_created) 
        {
            $this->_user_id = $user_id;
            $this->_first_name = $first_name;
            $this->_last_name = $last_name;
            $this->_email = $email;
            $this->_username = $username;
            $this->_password = $password;
            $this->_date_created = $date_created;
        }
        public function getUserId() {
            return $this->_user_id;
        }
        public function getFirstName() {
            return $this->_first_name;
        }
        public function getLastName() {
            return $this->_last_name;
        }

        public function getPassword() {
            return $this->_password;
        }

        public function getDateCreated() {
            return $this->_date_created;
        }

        public function getDecks() {
            return false;
        }
    }
?>