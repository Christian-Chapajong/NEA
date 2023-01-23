<?php
    require_once("classes.php");

    function getFullPath() {
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $url = "https://";   
        } else {
            $url = "http://";   
        }  

        // append the host(domain name, ip) to the URL.   
        $url.= $_SERVER['HTTP_HOST'];   
        
        // append the requested resource location to the URL   
        $url.= $_SERVER['REQUEST_URI'];
        
        return $url;
    }

    function getCurrentPath() {
        // get full URL from function getFullPath()
        $url = getFullPath();
        // finds last occurence of '/' in the url
        $backslashIndex = strrpos($url, '/');
        // save the substring of everything after the final backslash 
        $currentPath = substr($url, $backslashIndex + 1);

        return $currentPath;

    }

    function createID($length) {
        $numbers = '0123456789';
        // initialise randomString variable
        $id = '';
        
        // for the desired length of ID...
        for ($i = 0; $i < $length; $i++) {
            // create a random index number between 0 and the last index of the characters string
            $index = rand(0, strlen($numbers) - 1);
            // append the randomly selected character to randomString
            $id .= $numbers[$index];
        }
        // convert the id to a numeric value
        $id = $id + 0;
        
        return $id;
    }

    function daysToSeconds($days) {
        $days = $days*24*60*60 ;
        return $days; 
    }
    function createUserObject($user_data) {
        $user = new User($user_data['user_id'], $user_data['first_name'], $user_data['last_name'], $user_data['email'], $user_data['username'], $user_data['password'], $user_data['date_created']);        
        return $user;
    }
    function createDeckObject($deck_data) {
        $deck = new Deck($deck_data['deck_id'], $deck_data['user_id'], $deck_data['deck_title'], $deck_data['deck_description']);
        return $deck;
    }
    function checkLogin($mysqli)  {
        // Check if a user already has a current session i.e. is logged in already
        if(isset($_SESSION['user_id'])) {
            // set id to session user id
            $id = $_SESSION['user_id'];

            $sql = "SELECT * FROM users WHERE user_id = ? LIMIT 1";

            // if the prepare statement is successful 
            if( $stmt = $mysqli->prepare($sql) ) {
                // specify each data type and bind the paramaters of the sql statement with the variables,
                $stmt->bind_param('s', $id);
                // execute statement
                $stmt->execute();
                
                // get the result of the SELECT query
                $result = $stmt->get_result();
                // convert result into associative array
                $user_data = $result->fetch_assoc();

                // call createUserObject to create an instance of class 'User'
                $user = createUserObject($user_data);

                //return user
                return $user;

            } else { // if the prepare statement is unsuccessful 
                // add unsuccessful error to errors array
                $errors[] = $mysqli->errno . ' ' . $mysqli->error;
                
            }

        } else {
            //redirect to login
            header("Location: signup.php");
            die;
        }
    }
    function checkTime() {
        // get the current hour
        $hour = date('H', time()) - 1;
        // if the hour is between 0 and 11
        if ($hour >= 0 && $hour <= 11) {
            return "Good morning,";
        }
        // if the hour is between 12 and 16
        else if ($hour > 11 && $hour <= 18) {
            return "Good afternoon,";
        }
        // if the hour is between  19 and 23
        else {
            return "Good evening,";
        }
    }

    function rowsToArray($result) {
        $rows = [];
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

?>