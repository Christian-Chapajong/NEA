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
    $deck_length = count($cards);

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once("partials/head.php"); ?>
<body>
    <?php require_once("partials/navbar.php") ?>

    <main>
        <div class="page-wrap">
            <div class="container mt-5">
                <div class="d-flex justify-content-between mb-4">
                    <div class="deck-info">
                        <p>
                            <strong>Deck title:</strong>
                            <?php echo $deck_title ?>
                            <br>
                            <?php echo $deck_description ?>
                        </p>
                    </div>
                    <a href="save.php?deck_id=<?php echo $deck_id ?>&deck_title=<?php echo $deck_title ?>&user_id=<?php echo $user_id ?>&deck_description=<?php echo $deck_description ?>&deck_length=<?php echo $deck_length ?>">
                        <button class="btn btn-primary c-btn" style="color: white">Save Deck</button>
                    </a>
                </div>
                
                <?php if (count($cards)) { ?>
                    <ul class="deck-list card-list">
                        <?php foreach ($cards as $card) { ?>
                            <li class="deck-list__item card-list__item border-rad-1 text-start p-3 mb-2">
                                <div class="row">
                                    <div class="col-12 col-md-6 text-center">
                                        <p>
                                            <strong>Front</strong>
                                        </p>
                                        <p>
                                            <?php echo $card['flashcard_front'] ?>
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-6 text-center">
                                        <p>
                                            <strong>Back</strong>
                                        </p>
                                        <p>
                                            <?php echo $card['flashcard_back'] ?>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>

                <?php } else { ?>
                    <p class="mb-3" style="font-size: 1.5rem;">
                        <strong>No cards found.</strong>
                    </p>
                <?php } ?>

            </div>
        </div>
        
        <?php require_once("partials/footer.php") ?>

    </main>


    <?php require_once("partials/scripts.php") ?>
</body>
</html>