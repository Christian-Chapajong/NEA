<?php 
    session_start();

    require_once("partials/connection.php");
    require_once("partials/functions.php");

    $user = checkLogin($mysqli);

    $deck_id = $_GET['deck_id'];
    $deck_title = $_GET['deck_title'];
    $user_id = $_GET['user_id'];
    $deck_description = $_GET['deck_description'];
    $deck_length = $_GET['deck_length'];

    $new_deck_id = createID(5);
    $new_user_id = $user->getUserId();
    $null = NULL;

    // create new decks record
    $sql = "INSERT INTO decks (deck_id, user_id, deck_title, deck_description) VALUES (?, ?, ?, ?)";

    // if the prepare statement is successful 
    if ($stmt = $mysqli->prepare($sql)) {
        // specify each data type and bind the paramaters of the sql statement with the variables,
        $stmt->bind_param('ssss', $new_deck_id, $new_user_id, $deck_title, $deck_description);
        $stmt->execute();

    } else { // if the prepare statement is unsuccessful, output the error
        echo $mysqli->errno . ' ' . $mysqli->error;
    }

    // select all the flashcard ids that belong to the deck that is being viewed
    $sql = "SELECT flashcard_id FROM flashcards WHERE deck_id = {$deck_id} ";
    $result = $mysqli->query($sql);
    $flashcard_ids = rowsToArray($result);

    // create a temporary table of all the flashcards in the deck
    $sql = "CREATE table temporary_table AS SELECT * FROM flashcards WHERE deck_id = '{$deck_id}'";
    // execute query
    $mysqli->query($sql);

    // for each row in flashcard ids
    foreach ($flashcard_ids as $row) {
        // for each id in flashcard ids' rows 
        foreach ($row as $id) {
            // create a new flashcard ID
            $new_flashcard_id = createID(5);
            // update temporary table with new flashcard id and reset all spaced-repeition columns
            $sql = "UPDATE temporary_table SET flashcard_id = '{$new_flashcard_id}', deck_id = '{$new_deck_id}', last_performance_rating = '{$null}', easiness = 2.5, next_due_date = '{$null}', flashcard_interval = '{$null}', consecutive_correct_answers = '{$null}' WHERE flashcard_id = '{$id}' ";
            // execute query
            $mysqli->query($sql);
        }
    }

    // insert the new modified records from temporary table into flashcards
    $sql = "INSERT INTO flashcards SELECT * FROM temporary_table";
    $mysqli->query($sql);

    // drop temporary table
    $sql = "DROP TABLE temporary_table";
    $mysqli->query($sql);

    $success = true;


?>

<!DOCTYPE html>
<html lang="en">
<?php require_once("partials/head.php"); ?>
<body>
    <?php require_once("partials/navbar.php") ?>

    <main>
        <div class="page-wrap">
            <div class="container mt-5 text-center">
                <?php if (isset($success)) { ?>
                    <h1>Deck '<?php echo $deck_title ?>' has been saved </h1>
                    
                <?php } else { ?>
                    <h1>An error occurred when saving your deck</h1>
                <?php } ?>
                <a href="decks.php">
                    <button class="btn btn-primary c-btn" style="color: white">Decks</button>
                </a>
                
            </div>
        </div>
        <?php require_once("partials/footer.php") ?>

    </main>

    <?php require_once("partials/scripts.php") ?>
</body>
</html>