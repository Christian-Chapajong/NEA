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

        public function getDecks($mysqli) {
            $sql = "SELECT * FROM decks WHERE user_id = ?";
            // if the prepare statement is successful 
            if( $stmt = $mysqli->prepare($sql) ) {
                // specify each data type and bind the paramaters of the sql statement with the variables,
                $stmt->bind_param('s', $this->_user_id);
                $stmt->execute();

                $result = $stmt->get_result();
            }
            if (mysqli_num_rows($result) > 0) {
                // convert result with multiple rows into 2D associative array 
                $deck_data = rowsToArray($result);
                return $deck_data;
            }

            return;

            
        }
    }

    class Deck {
        public $_deck_id;
        public $_user_id;
        public $_deck_title;
        public $_deck_description;

        public function __construct($deck_id, $user_id, $deck_title, $deck_description ) 
        {
            $this->_deck_id = $deck_id;
            $this->_user_id = $user_id;
            $this->_deck_title = $deck_title;
            $this->_deck_description = $deck_description;
        }

    }
?>