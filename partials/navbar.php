<nav class="navbar navbar-expand-lg navbar-dark <?php echo isset($isTransparentNavbar) ? 'navbar_transparent' : 'navbar_coloured' ?>">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Spacer</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav">
                <a class="nav-link <?php echo getCurrentPath() == '' || getCurrentPath() == 'index.php' ? 'active' : '' ?>" aria-current="page" href="index.php">Home</a>
                <a class="nav-link <?php echo getCurrentPath() == 'search.php' ? 'active' : '' ?>" href="#">Search</a>
                <a class="nav-link <?php echo getCurrentPath() == 'decks.php' ? 'active' : '' ?>" href="decks.php">Decks</a>
            </div>
            <div class="ms-auto navbar-nav">
                <?php if (isset($_SESSION['user_id'])){ ?>
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-user"></i>    
                        </a>
                        <ul class="dropdown-menu profile-dropdown" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="">
                                <div class="profile-dropdown__profile-info d-flex">
                                    <i class="fa-solid fa-2x fa-circle-user"></i>    
                                    <div class="ms-2">
                                        <p><?php echo $user->_username ?></p>
                                        <p><?php echo $user->_email ?></p>
                                    </div>
                                </div>
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">
                                <button class="btn c-btn btn-outline-primary">Log out</button>
                            </a></li>
                        </ul>
                    </div>
                <?php } else { ?>
                    <a class="nav-link authentication-link <?php echo getCurrentPath() == 'login.php' ? 'd-none' : '' ?> " href="login.php">Login</a>
                    <a class="nav-link authentication-link <?php echo getCurrentPath() == 'signup.php' ? 'd-none' : '' ?>" href="signup.php">Signup</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>