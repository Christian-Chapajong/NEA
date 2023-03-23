<?php 
    session_start();

    require_once("partials/connection.php");
    require_once("partials/functions.php");

    $user = checkLogin($mysqli);

    if (isset($_POST['search'])) {
        $search = $_POST['search'];
        // split the search query into its individual keywords and save to an array
        $searchArray = explode(' ', $search);
        // initalise the where query
        $whereClause = '';

        foreach ($searchArray as $keyword) {
            // if the where clause has already been added to...
            if (!empty($whereClause)) {
                // append OR to the clause
                $whereClause .= " OR " ;
            }
            // append LIKE operator to check for presence of the keyword
            $whereClause .= "deck_title LIKE '%{$keyword}%'";
        }

        // select the decks where the search terms are present
        $sql = "SELECT * FROM decks WHERE {$whereClause}";

        $result = $mysqli->query($sql);
        $searchResults = rowsToArray($result);

    }

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once("partials/head.php"); ?>
<body>
    <?php require_once("partials/navbar.php") ?>

    <main>
        <div class="container mt-5">
            <form method="POST">
                <div class="input-group">
                    <div class="form-outline flex-grow-1">
                        <input type="search" id="search" class="form-control" name="search" placeholder="Search"value="<?php echo isset($search) ? $search : '' ?>"/>
                    </div>
                    <button type="button" class="btn btn-primary" type="submit" for>
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- If there are search results -->
            <?php if (isset($_POST['search'])) { ?>
                <?php if (count($searchResults)) { ?>
                    <ul class="deck-list mt-4">
                        <?php foreach ($searchResults as $deck) { ?>
                            <li class="deck-list__item border-rad-1 text-start p-3 mb-2">
                                <div class="deck-list__top">
                                    <h4 class="d-inline-block">
                                        <a class="link" href="view.php?deck_id=<?php echo $deck['deck_id'] ?>&deck_title=<?php echo $deck['deck_title'] ?>&user_id=<?php echo $deck['user_id'] ?>&deck_description=<?php echo $deck['deck_description']; ?>">
                                            <?php echo $deck['deck_title']; ?>
                                        </a>
                                    </h4>
                                    <div class="dropdown float-end">
                                        <i class="fa-solid fa-ellipsis-vertical fa-2x d-inline-block pe-3 dropdown-toggle link text-decoration-none" type="button" id="deck-options" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                        <ul class="dropdown-menu" aria-labelledby="deck-options">
                                            <li><a class="dropdown-item" href="save.php?deck_id=<?php echo $deck['deck_id']; ?>">Save to library </a></li>
                                        </ul>
                                    </div>
                                </div>

                                <?php echo $deck['deck_description'] ? "<span>" . $deck['deck_description'] . "</span>" : '' ;?>

                            </li>
                        <?php } ?>
                    </ul>

                <?php } else { ?>
                    <p class="mb-3" style="font-size: 1.5rem;">
                        <strong>No decks found.</strong>
                    </p>
                <?php } ?>
            <?php } ?>

        </div>

    </main>

    <?php require_once("partials/scripts.php") ?>
</body>
</html>