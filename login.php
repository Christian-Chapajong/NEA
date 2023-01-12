<?php 

    session_start();

	include("partials/connection.php");
	include("partials/functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST") {
		//something was posted
		$username = $_POST['username'];
		$password = $_POST['password'];

        // initialize errors list
        $errors = [];

		//read from database
        $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
        // if the prepare statement is successful 
        if( $stmt = $mysqli->prepare($sql) ) {
            // specify each data type and bind the paramaters of the sql statement with the variables,
            $stmt->bind_param('s', $username);
            $stmt->execute();

            $result = $stmt->get_result();
        }

        if (mysqli_num_rows($result) > 0) {
            // convert result into associative array
            $user_data = mysqli_fetch_assoc($result);
            
            if(isset($user_data) && $user_data['password'] === $password) {
                $_SESSION['user_id'] = $user_data['user_id'];
                createUserObject($user_data);
                header("Location: home.php");
                die;
            } else {
                $errors[] = "Password is incorrect.";
            }
        } else {
            $errors[] = "Username does not exist.";
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
                        <img class="img-fluid w-100 p-3" src="assets/img/WI-screens.svg" alt="Login image">
                    </div>
                    <div class="authentication_right col-12 col-md-6 d-flex justify-content-center align-items-center">
                        <div class="authentication_right__inner w-100">
                            <h1>Log in</h1>
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
                                    <input type="text" class="form__field" placeholder="Username" name="username" value="<?php echo isset($username) ? $username : '' ?>" required />
                                    <label for="first_name" class="form__label">Username</label>
                                </div>
                                <div class="form__group field">
                                    <input type="password" class="form__field" placeholder="Password" name="password" required />
                                    <label for="last_name" class="form__label">Password</label>
                                </div>

                                <button class="btn c-btn btn-outline-primary mt-4 mb-3" type="submit">Log in</button>
                            </form>

                            <a lass="authentication__redirect"  href="signup.php">Click to Signup</a>

                        </div>

                        

                    </div>
                </div>
            </div> 
        </main>

        <?php require_once("partials/scripts.php") ?>

    </body>
</html>