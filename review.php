<?php 
    session_start();

    require_once("partials/connection.php");
    require_once("partials/functions.php");

    $user = checkLogin($mysqli);

    // Spaced Repetition Algorithm (SM-2)

    //set timezone
    date_default_timezone_set('GMT');

    // set current time
    $date = date("Y-m-d H:i:s"); 
    // set current day
    $day = date("Y-m-d"); 

    // define null so that it can be passed as a parameter
    $null = NULL; 

    // get deck_id from URL
    $deck_id = $_GET['deck_id'];
    // if the prepare statement is successful
    $sql = "SELECT * FROM flashcards WHERE deck_id = ?";

    // select the flashcards where the due date is passed or null
    $sql = "SELECT * FROM flashcards WHERE deck_id = ? AND (next_due_date < ? OR next_due_date <=> ? OR DATE(next_due_date) = ?)";
    // if the prepare statement is successful 
    if( $stmt = $mysqli->prepare($sql) ) {
        // specify each data type and bind the paramaters of the sql statement with the variables,
        $stmt->bind_param('ssss', $deck_id, $date, $null, $day);
        $stmt->execute();

        $result = $stmt->get_result();
    }
    // if there are overdue cards...
    if (mysqli_num_rows($result) > 0) {
        // convert result with multiple rows into 2D associative array 
        $overdueCards = rowsToArray($result);
        // take the card at the top of the stack
        $currentCard = $overdueCards[0];
    }

    // if the current card has an image
    if (isset($currentCard) && $currentCard['image_id']) {
        // there should only be one image with this unqiue identifier but limit 1 ensures this
        $sql = "SELECT filename, on_front from images WHERE image_id = ? LIMIT 1";

        // if the prepare statement is successful 
        if( $stmt = $mysqli->prepare($sql) ) {
            // specify each data type and bind the paramaters of the sql statement with the variables, 
            $stmt->bind_param('s', $currentCard['image_id']);
            $stmt->execute();

            $result = $stmt->get_result();
            $image = rowsToArray($result);
            
            $filename = $image[0]['filename'];
            $on_front = $image[0]['on_front'];


        }
    }
    
    // if a performance rating button has been posted and overdueCards is set
    // echo "<br>Performance Ratings<br>";
    // echo isset($_POST['easy']) || isset($_POST['okay']) || isset($_POST['okay']) || isset($_POST['again']);

    // unset($_POST['easy'], $_POST['okay'], $_POST['okay'], $_POST['again']);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        if (isset($_POST['easy'])){
            echo "easy";
            // set performance rating to 3 if 'easy' is posted
            $performance_rating = 3;

        } elseif (isset($_POST['okay'])){
            echo "okay";

            // set performance rating to 2 if 'okay' is posted
            $performance_rating = 2;

        }elseif (isset($_POST['hard'])) {
            echo "hard";

            // set performance rating to 1 if 'hard' is posted
            $performance_rating = 1;

        } elseif (isset($_POST['again'])) {
            echo "again";

            // set performance rating to 0 if 'again...' is posted
            $performance_rating = 0;  
        }

        SpacedRepetitionAlgorithm($mysqli, $currentCard['flashcard_id'], $performance_rating, $currentCard['easiness'], $currentCard['next_due_date'], $currentCard['consecutive_correct_answers']);
    }

    // if a performance rating has been posted
    function SpacedRepetitionAlgorithm($mysqli, $flashcard_id, $performance_rating, $easiness, $next_due_date, $consecutive_correct_answers) {
        echo "algorithm run";
        //set current time
        $date = date("Y-m-d H:i:s"); 

        // if correct answer
        if ($performance_rating >= 2) { 
            // adjust easiness
            $easiness += -0.8 + (0.28 * $performance_rating) + (0.02 * ($performance_rating * pow($performance_rating, 2)));
            //increment number of consecutive correct answers
            $consecutive_correct_answers++;
            // calculate number of days to add onto next due date
            $days = ceil($easiness * $consecutive_correct_answers - 1);
            // convert days to seconds with pre-written function
            $flashcard_interval = daysToSeconds($days);
            // set next due date
            $next_due_date = date('Y-m-d H:i:s', strtotime($date . "+{$flashcard_interval} seconds"));

        } else {
            
            if ($performance_rating == 0) { // if again option
                $flashcard_interval = 60; // 60 seconds
                $next_due_date = date('Y-m-d H:i:s', strtotime($date . "+{$flashcard_interval} seconds"));

                
            } elseif ($easiness < 5) { // hard or okay but easiness is still below 5
                $flashcard_interval = 600; // 10 minutes in seconds
                $next_due_date = date('Y-m-d H:i:s', strtotime($date . "+{$flashcard_interval} seconds"));

            } 
            else {
                // hard or okay but easiness is above 5
                $flashcard_interval = daysToSeconds(1); // 1 day in seconds
                $next_due_date = date('Y-m-d H:i:s', strtotime($date . "+{$flashcard_interval} seconds"));

            }

            $consecutive_correct_answers = 0;

        }


        // save the sql query as a string
        $sql = "UPDATE flashcards SET last_performance_rating = ?, easiness = ?, next_due_date = ?, flashcard_interval = ? WHERE flashcard_id = ?";

        // if the prepare statement is successful 
        if( $stmt = $mysqli->prepare($sql) ) {
            // specify each data type and bind the paramaters of the sql statement with the variables, 
            $stmt->bind_param('idsis', $performance_rating, $easiness, $next_due_date, $flashcard_interval, $flashcard_id);
            $stmt->execute();

            header("Location: review.php?" . $_SERVER['QUERY_STRING']);
            die;

        } else { // if the prepare statement is unsuccessful 
            $error = $mysqli->errno . ' ' . $mysqli->error;
            echo $error; // report an error
        }

    }
?>

<!doctype html>
<html lang="en">
  <?php require_once("partials/head.php") ?>
  <body>
    <?php require_once("partials/navbar.php") ?>

    <main>
        <div class="page-wrap">
            <div class="container mt-5">
                <div class="row justify-content-center">
                <?php if (isset($overdueCards)) {  ?>
                    <span class="mb-3" >
                        <strong>Overdue cards:</strong> <?php echo count($overdueCards) ?> 
                    </span>
                    <div class="flip-card">
                        <div class="flip-card-inner" id="flip-card-inner">
                            <div class="flip-card-front p-4 d-flex justify-content-center align-items-center ">
                                <div class="front-inner ">
                                    <?php 
                                        $front_colour = $currentCard['front_colour'];

                                        echo "<span style='color: $front_colour'> {$currentCard['flashcard_front']} </span>";

                                        if (isset($image) && $on_front) {
                                            echo "
                                                <div class='uploaded-img' style='max-width: 400px; margin: 0 auto;'>
                                                    <img src='./images/{$filename}'/>
                                                </div>
                                            ";
                                        }   
                                    ?>
                                </div>
                            </div>

                            <div class="flip-card-back p-4 d-flex justify-content-center align-items-center">
                                <div class="back-inner">
                                    <?php 
                                        $back_colour = $currentCard['back_colour'];

                                        echo "<span style='color: $back_colour'> {$currentCard['flashcard_back']} </span>";;

                                        if (isset($image) && !($on_front)) {
                                            echo "
                                                <div class='uploaded-img' style='max-width: 400px; margin: 0 auto;'>
                                                    <img src='./images/{$filename}'/>
                                                </div>
                                            ";
                                        } 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center mt-5">
                    <form method="POST" id="performanceRating" class="d-none">
                        <button type="submit" name="again" class="btn btn-outline-danger">Again...</button>
                        <button type="submit" name="hard" class="btn btn-outline-danger">Hard</button>
                        <button type="submit" name="okay" class="btn btn-outline-secondary">Okay</button>
                        <button type="submit" name="easy" class="btn btn-outline-success">Easy</button>
                    </form>
                    </div>
                    <?php } else { ?>
                    <div class="text-center">
                        <h2>No overdue cards</h2>
                        <a href="decks.php">
                            <button class="c-btn btn btn-primary">Decks</button>
                        </a>
                    </div>

                    <?php } ?>
                                

                </div>

                                
            </div>
        </div>
        <?php require_once("partials/footer.php") ?>

    </main>
    

    <?php require_once("partials/scripts.php") ?>
    <script>
        // when document has loaded...
        document.addEventListener('DOMContentLoaded', function () {
            // define card inner and performance form
            const cardInner = document.getElementById("flip-card-inner");
            const performanceForm = document.getElementById("performanceRating");
            cardInner.addEventListener("click", function() {
                // get the class list of performance form
                performanceClassList = performanceForm.classList;
                // remove the display none property
                performanceClassList.remove("d-none");

                // get the class list of the card
                var cardClassList = cardInner.classList;
                // if card is currently flipped
                if (cardClassList.contains("flip")) {
                    // remove flip class
                    cardClassList.remove("flip");
                } else {
                    // else add flip class
                    cardClassList.add("flip");
                }
            });
        });
    </script>
    </body>
</html>
