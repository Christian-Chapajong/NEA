<?php 
    // session_start();
    require_once("partials/connection.php");
    require_once("partials/functions.php");

    // Spaced Repetition Algorithm (SM-2)

    // if a performance rating has been posted
    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        if (isset($_POST['easy'])){
            // set performance rating to 3 if 'easy' is posted
            $performance_rating = 3;

        } elseif (isset($_POST['okay'])){
            // set performance rating to 2 if 'okay' is posted
            $performance_rating = 2;

        }elseif (isset($_POST['hard'])){
            // set performance rating to 1 if 'hard' is posted
            $performance_rating = 1;

        } else {
            // set performance rating to 0 if 'again...' is posted
            $performance_rating = 0;  
        } 
    }


    $easiness = 2.5;
    $consecutive_correct_answers = 0;
    //set timezone
    date_default_timezone_set('GMT');
    //set current time
    $date = date("Y-m-d H:i:s"); 

    // if $performance_rating is set
    if (isset($performance_rating)) {
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
            //this is done for testing purposes as date should stay as current time as uses may review overdue cards much later than next due date
            $date = $next_due_date; 

        } else {
            // unset($days);
            
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
            //this is done for testing purposes
            $date = $next_due_date;
        }

        // $a[] = [$i, $performance_rating, $consecutive_correct_answers, $easiness, $next_due_date, isset($days) ? "{$days} d" : "{$minutes} m"]; //ternary - if days is set, add days to array, if not, don't add

        // save the sql query as a string
        $sql = "INSERT INTO flashcards (flashcard_id, last_performance_rating, easiness, next_due_date, flashcard_interval) VALUES (?, ?, ?, ?, ?)";
        // create a unique ID for the flashcard using the createID function with a length of 10 
        $flashcard_id = createID(5); 

        // if the prepare statement is successful 
        if( $stmt = $mysqli->prepare($sql) ) {
            // specify each data type and bind the paramaters of the sql statement with the variables, 
            $stmt->bind_param('sidsi', $flashcard_id, $performance_rating, $easiness, $next_due_date, $flashcard_interval);
            $stmt->execute();
        } else { // if the prepare statement is unsuccessful 
            $error = $mysqli->errno . ' ' . $mysqli->error;
            echo $error; // report an error
        }

    }
    
    

    // $a[] = [$i, $performance_rating, $consecutive_correct_answers, $easiness, $next_due_date, isset($days) ? $days : null];
    // foreach ($a as $row) {
    //     echo implode(' ', $row) . '<br><br>';
    // }
?>

<!doctype html>
<html lang="en">
  <?php require_once("partials/head.php") ?>
  <body>
    <?php require_once("partials/navbar.php") ?>

    <div class="container mt-5">
        <form method="POST">
            <button type="submit" name="again" class="btn btn-outline-danger">Again...</button>
            <button type="submit" name="hard" class="btn btn-outline-danger">Hard</button>
            <button type="submit" name="okay" class="btn btn-outline-secondary">Okay</button>
            <button type="submit" name="easy" class="btn btn-outline-success">Easy</button>
        </form>

        <?php 
            if (isset($performance_rating)) {
                $a[] = [$performance_rating, $consecutive_correct_answers, $easiness, $next_due_date, $flashcard_interval];
            }
            
        ?>
        <table class="table table-striped table-bordered"> 
            <tr>
                <th>Performance</th>
                <th>Consecutive Correct Answers</th>
                <th>Easiness</th>
                <th>Next Due Date</th>
                <th>Flashcard Interval</th>
            </tr>
            <?php 
                if (isset($a)) {
                    foreach ($a as $row) { // for each row in array $a
                        echo "<tr>"; // output opening tag for table row
                        for ($i = 0; $i < count($row); $i++) { // for number of items in row
                            echo "<td> $row[$i] </td>"; // output item as table data
                        }
                        echo "</tr>"; // output closing tag for table row
                    }    
                }

            ?>
        </table>
        
    </div>

    <?php require_once("partials/scripts.php") ?>
    <script>
        
    </script>
    </body>
</html>