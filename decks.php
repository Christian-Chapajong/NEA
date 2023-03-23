<!doctype html>
<html lang="en">
<?php
session_start();

require_once("partials/head.php");
require_once("partials/functions.php");

$user = checkLogin($mysqli);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $deck_title = $_POST['deck_title'];
    // if deck description is filled then save into variable
    $_POST['deck_description'] ? $deck_description = $_POST['deck_description'] : '';

    $deck_id = createID(5);
    $user_id = $user->getUserId();

    // add deck title to session so that it can be used on other pages
    $_SESSION['deck_id'] = $deck_id;
    $_SESSION['deck_title'] = $deck_title;

    // create a query which inserts a new row into decks
    $sql = "INSERT INTO decks (deck_id, user_id, deck_title, deck_description) VALUES (?, ?, ?, ?)";

    // if the prepare statement is successful 
    if ($stmt = $mysqli->prepare($sql)) {
        // specify each data type and bind the paramaters of the sql statement with the variables,
        $stmt->bind_param('ssss', $deck_id, $user_id, $deck_title, $deck_description);
        $stmt->execute();

        header("Location: create.php");
        die;
    } else { // if the prepare statement is unsuccessful, output the error
        echo $mysqli->errno . ' ' . $mysqli->error;
    }
}

?>

<body>
    <?php require_once("partials/navbar.php"); ?>
    <main>
        <div class="page-wrap">
            <div class="container">
                <section id="decks-list">

                    <h1 class="decks-heading">Decks</h1>


                    <div class="text-center">
                        <?php $decks = $user->getDecks($mysqli); ?>
                        <?php if ($decks) { ?>
                            <ul class="deck-list">
                                <?php foreach ($decks as $deck) { ?>
                                    <li class="deck-list__item border-rad-1 text-start p-3 mb-2">
                                        <div class="deck-list__top">
                                            <h4 class="d-inline-block">
                                                <a class="link" href="review.php?deck_id=<?php echo $deck['deck_id']; ?>">
                                                    <?php echo $deck['deck_title']; ?>
                                                </a>
                                            </h4>
                                            <div class="dropdown float-end">
                                                <i class="fa-solid fa-ellipsis-vertical fa-2x d-inline-block pe-3 dropdown-toggle link text-decoration-none" type="button" id="deck-options" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                <ul class="dropdown-menu" aria-labelledby="deck-options">
                                                    <li><a class="dropdown-item" href="create.php?deck_id=<?php echo $deck['deck_id']; ?>">Add cards</a></li>
                                                    <li><a class="dropdown-item" href="#">Edit cards</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <?php echo $deck['deck_description'] ? "<span>" . $deck['deck_description'] . "</span>" : '' ;?>

                                    </li>
                                <?php } ?>
                            </ul>

                        <?php } else { ?>
                            <p class="mb-3" style="font-size: 1.5rem;">
                                <strong>No decks to see here!</strong>
                            </p>
                        <?php }; ?>

                        <button class="btn c-btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createDeck">
                            Add new Deck
                        </button>

                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="createDeck" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createDeckLabel" aria-hidden="true">
                        <div class="modal-dialog absolute-center">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Create Deck</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" id="createDeckForm">
                                        <div class="form__group form__group_dark">
                                            <input type="text" class="form__field" placeholder="Title" name="deck_title" maxlength="50" required />
                                            <label for="deck_title" class="form__label">Title</label>
                                        </div>
                                        <div class="form__group form__group_dark">
                                            <textarea class="form__field form__field_textarea" placeholder="Description" name="deck_description" maxlength="200"></textarea>
                                            <label for="deck_description" class="form__label">Description</label>

                                        </div>

                                    </form>

                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button class="btn c-btn btn-outline-primary mt-4 mb-3 " form="createDeckForm" type="submit">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>



                </section>


            </div>
        </div>
    </main>
    <?php require_once("partials/scripts.php") ?>
</body>

</html>