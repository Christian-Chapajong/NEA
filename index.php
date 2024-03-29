<?php
    session_start();
    require_once("partials/functions.php");

    if (isset($_SESSION['user_id'])) {
        header("Location: home.php");
    }

    $isTransparentNavbar = true;
?>

<!doctype html>
<html lang="en">
    <?php require_once("partials/head.php"); ?>
    <body>
        <?php require_once("partials/navbar.php") ?>
        <main>
            <div class="page-wrap m-0">
                <div class="row">
                    <div class="landing-bg col-12">
                        <div class="landing-text text-center absolute-center">
                            <h1 class="landing-text__heading mb-4">Welcome to Spacer</h1>
                            <div class="landing-text__btns d-flex flex-column flex-md-row justify-content-center text-center">
                                <a href="signup.php">
                                    <button class="btn c-btn btn-info mb-2 mb-md-0">Signup</button>
                                </a>
                                <a href="login.php">
                                    <button class="btn c-btn btn-outline-info">Login</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php require_once("partials/footer.php") ?>

        </main>

        
        <?php require_once("partials/scripts.php") ?>
    </body>
</html>