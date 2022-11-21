<?php require("partials/functions.php"); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Spacer</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav">
                <div>
                    <a class="nav-link <?php echo getURL() == 'http://localhost/NEA/' || getURL() == 'http://localhost/NEA/index.php' ? 'active' : '' ?>" aria-current="page" href="index.php">Home</a>
                </div>
                <div>
                    <a class="nav-link <?php echo getURL() == 'http://localhost/NEA/search.php' ? 'active' : '' ?>" href="#">Search</a>
                </div>
                <div class="me-auto">
                    <a class="nav-link <?php echo getURL() == 'http://localhost/NEA/create.php' ? 'active' : '' ?>" href="create.php">Create</a>
                </div>
                <div>
                    <a class="nav-link authentication-link <?php echo getURL() == 'http://localhost/NEA/login.php' ? 'active' : '' ?>" href="#">Login</a>
                </div>
                <div>
                    <a class="nav-link authentication-link <?php echo getURL() == 'http://localhost/NEA/signup.php' ? 'active' : '' ?>" href="#">Signup</a>
                </div>
            </div>
        </div>
    </div>
</nav>