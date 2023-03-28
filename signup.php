<?php 
    session_start();
	require_once("partials/connection.php");
	require_once("partials/functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		// input was posted
        // trim() removes all whitespace
		$first_name = trim($_POST['first_name']);
		$last_name = trim($_POST['last_name']);
		$email = trim($_POST['email']);
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

        //initialize errors list
        $errors = [];

        // check if email or username already exist
        // create boolean flag to check for repetition
        $repeatedSignup = false;
        // query the database for any rows where the email or username is the same as the user's input
        $sql = "SELECT user_id FROM users WHERE email=? OR username=?";

        // if the prepare statement is successful 
        if( $stmt = $mysqli->prepare($sql) ) {
            // specify each data type and bind the paramaters of the sql statement with the variables,
            $stmt->bind_param('ss', $email, $username);
            $stmt->execute();

            $result = $stmt->get_result();
            if (mysqli_num_rows($result) > 0) {
                $repeatedSignup = true;
                $errors[] = "Username and/or Email already exists"; 
            }
        } else { // if the prepare statement is unsuccessful 
            // add unsuccessful error to errors array
            $errors[] = $mysqli->errno . ' ' . $mysqli->error;
        }

        if (!$repeatedSignup) {
            //initialize list of input
            $inputs = [$first_name, $last_name, $email, $username, $password];

            for ($i=0; $i < count($inputs); $i++) {
                //initialize Boolean flags
                $uppercase = false;
                $lowercase = false;
                $numeric = false;
                $specialCharacters = false;
                $length = false;
                
                // for each character in input
                foreach (str_split($inputs[$i]) as $char) {
                    // if character is uppercase, set flag to true
                    if (ctype_upper($char)) {
                        $uppercase = true;
                    // if character is lowercase, set flag to true
                    } else if (ctype_lower($char)) {
                        $lowercase = true;
                    // if character is numeric, set flag to true
                    } else if (is_numeric($char)) {
                        $numeric = true;
                    // if character is special character, set flag to true
                    } else if (strpos('[@_!#$%^&*()<>?/|}{~:]', $char)) {
                        $specialCharacters = true;
                        
                    }
                }


                switch ($i) {
                    case 0: // is first name
                        // if numeric is true, add error message
                        $numeric ? $errors[] = "First name cannot contain numeric values" : "" ;
                        // if special characters is true, add error message
                        $specialCharacters ? $errors[] = "First name cannot contain special characters" : "" ;
                        break;
                    case 1: // is last name
                        // if numeric is true, add error message
                        $numeric ? $errors[] = "Last name cannot contain numeric values" : "" ;
                        // if special characters is true, add error message
                        $specialCharacters ? $errors[] = "Last name cannot contain special characters" : "" ;
                        break;
                    case 3: // is username
                        // check length of username, if more than 5, set length to true
                        strlen($inputs[3]) > 5 ? $length = true : "" ;
                        // if length is false, add error message
                        $length ? "" : $errors[] = "Username must be at least 6 characters long";
                        // if special characters is true, add error message
                        $specialCharacters ? $errors[] = "Username cannot contain special characters" : "";
                        break;
                    case 4: // is password
                        // check length of password, if more than 8, set length to true
                        strlen($inputs[4]) > 7 ? $length = true : "";
                        // if length is false, add error message
                        $length ? "" : $errors[] = "Password must be at least 8 characters long";
                        // if uppercase is false, add error message
                        $uppercase ? "" : $errors[] = "Password must contain an uppercase letter";
                        // if lowercase is false, add error message
                        $lowercase ? "" : $errors[] = "Password must contain a lowercase letter";
                        // if numeric is false, add error message
                        $numeric ? "" : $errors[] = "Password must contain an number";
                }
            }
            if (count($errors) == 0) {
                
                // save the sql query as a string
                $sql = "INSERT INTO users (user_id, first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?, ?)";
                // create a unique ID for the user using the createID function with a length of 10 
                $user_id = createID(5); 

                // if the prepare statement is successful 
                if( $stmt = $mysqli->prepare($sql) ) {
                    // specify each data type and bind the paramaters of the sql statement with the variables,
                    $stmt->bind_param('ssssss', $user_id, $first_name, $last_name, $email, $username, $password);
                    $stmt->execute();
                    
                    // set session user_id to confirm that user has been signed up
                    $_SESSION['user_id'] = $user_id;
                
                    // redirect to home page
                    header("Location: home.php");
                    // kill connection
                    die;

                } else { // if the prepare statement is unsuccessful 
                    // add unsuccessful error to errors array
                    $errors[] = $mysqli->errno . ' ' . $mysqli->error;
                    
                }
            }
        }
        
	}
?>


<!DOCTYPE html>
<html lang="en">
    <?php require_once("partials/head.php"); ?>
    <body>
        <?php require_once("partials/navbar.php") ?>
        <main>
            <div class="page-wrap mt-0">
                <div class="row h-100">
                    <div class="authentication_left col-12 col-md-6 d-flex justify-content-center">
                        <img class="img-fluid w-100 p-3" src="assets/img/WI-sign-up.svg" alt="Sign up Image">
                    
                    </div>
                    <div class="authentication_right col-12 col-md-6 d-flex justify-content-center align-items-center">
                        <div class="authentication_right__inner w-100">
                            <h1>Sign up</h1>
                            <?php
                                if (isset($errors)) {
                                    foreach ($errors as $error) {
                                        echo "
                                            <div class='error p-3 mb-2 mx-auto'>
                                                {$error}
                                            </div>
                                        ";
                                    }
                                }  
                            ?>
                            <form method="post">
                                <div class="form__group field">
                                    <input type="input" class="form__field" placeholder="First name" name="first_name" value="<?php echo isset($first_name) ? $first_name : '' ?>" required />
                                    <label for="first_name" class="form__label">First name</label>
                                </div>
                                <div class="form__group field">
                                    <input type="input" class="form__field" placeholder="Last name" name="last_name" value="<?php echo isset($last_name) ? $last_name : '' ?>" required />
                                    <label for="last_name" class="form__label">Last name</label>
                                </div>
                                <div class="form__group field">
                                    <input type="email" class="form__field" placeholder="Email address" name="email" value="<?php echo isset($email) ? $email : '' ?>" required />
                                    <label for="email" class="form__label">Email address</label>
                                </div>
                                <div class="form__group field">
                                    <input type="input" class="form__field" placeholder="Username" name="username" value="<?php echo isset($username) ? $username : '' ?>" required />
                                    <label for="username" class="form__label">Username</label>
                                </div>
                                <div class="form__group field">
                                    <input type="password" class="form__field" placeholder="Password" name="password" required />
                                    <label for="password" class="form__label">Password</label>
                                </div>
                                
                
                                <button class="btn c-btn btn-outline-light mt-4 mb-3 authentication-btn" type="submit">Sign up</button>
                            </form>

                            <a class="authentication__redirect" href="login.php">Click to Login</a>
                    
                        </div>
                        

                    </div>
                </div>
            </div> 
            <?php require_once("partials/footer.php") ?>

        </main>


        <?php require_once("partials/scripts.php") ?>
    </body>
</html>