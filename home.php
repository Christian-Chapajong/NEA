<!doctype html>
<html lang="en">
    <?php 
        session_start();

        $isSlick = true; 
        require_once("partials/connection.php");
        require_once("partials/head.php");
        require_once("partials/functions.php");

	    $user = checkLogin($mysqli);

    ?>
    
    
    <body>
        <?php require_once("partials/navbar.php") ?>
        <main>
        <div class="page-wrap">
            <div class="container">
            <div class="greeting">
                <h1>
                    <?php echo checkTime() ?>
                    <p class="user-first-name">
                        <?php echo $user->getFirstName() ?>
                    </p>
                </h1>
                
            </div>
            <section id="section-recently-reviewed">
                <div class="recently-reviewed my-3">
                <h3 class="mb-4">Recently Reviewed</h3>
                <div class="container">
                <div class="recently-reviewed__slick row gx-5">
                    <div class="recently-reviewed__slick-slide card col">
                        <div class="card-body">
                            <h5 class="card-title">Computer Science</h5>
                            <h6 class="card-subtitle mb-2 text-danger">10 cards <strong>overdue</strong></h6>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                    <div class="recently-reviewed__slick-slide card col">
                        <div class="card-body">
                            <h5 class="card-title">Mathematics</h5>
                            <h6 class="card-subtitle mb-2 text-danger">6 cards <strong>overdue</strong></h6>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                    <div class="recently-reviewed__slick-slide card col">
                        <div class="card-body">
                            <h5 class="card-title">Driving theory</h5>
                            <h6 class="card-subtitle mb-2 text-danger">2 cards <strong>overdue</strong></h6>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                </div>
                </div>
                
                </div>
            </section>
            
            <section id="section-progress-chart">
                <h3>Progress Chart</h3>

                <div class="progress-chart__key">
                    <div class="d-flex align-items-center">
                        <div class="fill-rectangle fill-rectangle_active d-inline-block"></div>
                        <span>Active</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="fill-rectangle fill-rectangle_inactive d-inline-block"></div>
                        <span>Inactive</span>
                    </div>
                </div>
                <div class="progress-chart d-flex">
                    <div class="progress-chart__day inactive">
                        Monday
                    </div>
                    <div class="progress-chart__day active">
                        Tuesday
                    </div>
                    <div class="progress-chart__day active">
                        Wednesday
                    </div>
                    <div class="progress-chart__day inactive">
                        Thursday
                    </div>
                    <div class="progress-chart__day active">
                        Friday
                    </div>
                    <div class="progress-chart__day">
                        Saturday
                    </div>
                    <div class="progress-chart__day">
                        Sunday
                    </div>
                </div>
            </section>
            </div>
        </div>

        
        </main>


        <?php require_once("partials/scripts.php") ?>
        <script>
            $('.recently-reviewed__slick').slick({
                infinite: false,
                slidesToShow: 3,
                slidesToScroll: 3,
                responsive: [
                    {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1.5,
                        slidesToScroll: 1,
                    },
                    }
                ]
            });

            $('.progress-chart').slick({
                infinite: false,
                slidesToShow: 5.5,
                slidesToScroll: 3,
                responsive: [
                    {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3.5,
                        slidesToScroll: 1,
                    },
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 2.25,
                        slidesToScroll: 1,
                    },
                    }
                ]
            });

        </script>
    </body>
</html>