<?php 
    session_start();
    require("connection.php");

    // Spaced Repetition Algorithm (SM-2)

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        if  (isset($_POST['perfect'])){
            $performance_rating = 4;

        } elseif (isset($_POST['good'])){
            $performance_rating = 3;

        } elseif (isset($_POST['okay'])){
            $performance_rating = 2;

        }elseif (isset($_POST['hard'])){
            $performance_rating = 1;

        } else {
            $performance_rating = 0;  
        } 
    }


    $easiness = 2.5;
    $consecutive_correct_answers = 0;
    //set timezone
    date_default_timezone_set('GMT');
    //set current time
    $date = date("Y-m-d H:i:s"); 

    // $a = [];
    if (isset($performance_rating)) {
        if ($performance_rating >= 3) { // if correct answer
            // adjust easiness
            $easiness += -0.8 + (0.28 * $performance_rating) + (0.02 * ($performance_rating * pow($performance_rating, 2)));
            //increment number of consecutive correct answers
            $consecutive_correct_answers++;
            // calculate number of days to add onto next due date
            $days = ceil(3 * $easiness * $consecutive_correct_answers - 1);
            // set next due date
            $next_due_date = date('Y-m-d H:i:s', strtotime($date . "+{$days} day"));
            //this is done for testing purposes as date should stay as current time as uses may review overdue cards much later than next due date
            $date = $next_due_date; 
    
        } else {
    
            if ($performance_rating == 0) {
                // again option
                $next_due_date = date('Y-m-d H:i:s', strtotime($date . "+1 minutes"));
    
            } elseif ($easiness < 5) {
                // hard or okay but easiness is still below 5
                $next_due_date = date('Y-m-d H:i:s', strtotime($date . "+10 minutes"));
    
            } 
            else {
                // hard or okay but easiness is above 5
                $days = 1;
                $next_due_date = date('Y-m-d H:i:s', strtotime($date . "+1 day"));
    
            }
    
            $consecutive_correct_answers = 0;
            //this is done for testing purposes
            $date = $next_due_date;
        }
    
        $sql = "INSERT INTO flashcards (next_due_date) VALUES (?)";
        if( $stmt = $mysqli->prepare($sql) ) {
            $stmt->bind_param('s', $next_due_date);
            $stmt->execute();
        } else {
            $error = $mysqli->errno . ' ' . $mysqli->error;
            echo $error; 
        }
    }

    

    // $a[] = [$i, $performance_rating, $consecutive_correct_answers, $easiness, $next_due_date, isset($days) ? $days : null];
    // foreach ($a as $row) {
    //     echo implode(' ', $row) . '<br><br>';
    // }
?>

<!doctype html>
<html lang="en">
  <?php require("partials/head.php") ?>
  <body>
    <?php require("partials/navbar.php"); ?>

    <div class="container mt-5">
        <form method="POST">
            <button type="submit" name="again" class="btn btn-outline-danger">Again...</button>
            <button type="submit" name="hard" class="btn btn-outline-danger">Hard</button>
            <button type="submit" name="okay" class="btn btn-outline-secondary">Okay</button>
            <button type="submit" name="good" class="btn btn-outline-success">Good</button>
            <button type="submit" name="perfect" class="btn btn-outline-success">Perfect</button>
        </form>
        <table>
            <tr>
                <th>Next Due Date</th>
            </tr>
            <?php 
                if ($_SERVER['REQUEST_METHOD'] === "POST") {
                    echo "
                        <tr>
                            <td>$next_due_date</td>
                        </tr>
                    ";
                }
                echo "<br><br>";
            ?>
        </table>
        
    </div>

    <?php require("partials/scripts.php") ?>
    </body>
</html>