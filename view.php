<?php 
    session_start();

    require_once("partials/connection.php");
    require_once("partials/functions.php");

    $user = checkLogin($mysqli);

    $deck_id = $_GET['deck_id'];
    $deck_title = $_GET['deck_title'];
    $user_id = $_GET['user_id'];
    $deck_description = $_GET['deck_description'];
    
    $sql = "SELECT flashcard_front, flashcard_back, front_colour, back_colour FROM flashcards WHERE deck_id = {$deck_id}";

    $result = $mysqli->query($sql);
    $cards = rowsToArray($result);

    print_r($cards);


?>

<!DOCTYPE html>
<html lang="en">
<?php require_once("partials/head.php"); ?>
<body>
    <?php require_once("partials/navbar.php") ?>

    <main>
        <div class="container mt-5">
            <div class="d-flex">
                <div class="deck-info">
                    <p>Deck author: </p>
                    <p>Number of cards: </p>
                </div>
                <a href="save.php?deck_id=<?php echo $deck['deck_id']; ?>">
                    <button class="btn btn-primary c-btn">Save Deck</button>
                </a>
            </div>
            
            <?php if (count($cards)) { ?>
                <ul class="deck-list card-list">
                    <?php foreach ($searchResults as $deck) { ?>
                        <li class="deck-list__item card-list__item border-rad-1 text-start p-3 mb-2">
                            

                            <?php echo $deck['deck_description'] ? "<span>" . $deck['deck_description'] . "</span>" : '' ;?>

                        </li>
                    <?php } ?>
                </ul>

            <?php } else { ?>
                <p class="mb-3" style="font-size: 1.5rem;">
                    <strong>No decks found.</strong>
                </p>
            <?php } ?>

        </div>

    </main>

    <?php require_once("partials/scripts.php") ?>
</body>
</html>