<!doctype html>
<html lang="en">
    <?php 
        require("partials/head.php");
    ?>
    <body>
        <?php require("partials/navbar.php"); ?>
        <main>
        <div class="page-wrap">
            <div class="container">
            <div class="greeting">
                <h2>Good morning,</h2>
                <p class="user-first-name fs-3">Christian</p>
            </div>
            <section id="section-recently-reviewed">
                <div class="recently-reviewed my-3">
                <h3 class="mb-4">Recently Reviewed</h3>
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
            </section>
            
            <section id="section-progress-chart">
                <h3>Progress Chart</h3>
                <div class="progress-chart d-flex">
                <div class="progress-chart__day red">
                    Monday
                </div>
                <div class="progress-chart__day green">
                    Tuesday
                </div>
                <div class="progress-chart__day green">
                    Wednesday
                </div>
                <div class="progress-chart__day red">
                    Thursday
                </div>
                <div class="progress-chart__day green">
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


        <?php require("partials/scripts.php") ?>
    </body>
</html>