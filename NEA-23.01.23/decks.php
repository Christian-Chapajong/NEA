<!doctype html>
<html lang="en">
    <?php
        session_start();

        require_once("partials/head.php");
        require_once("partials/functions.php");
        
        $user = checkLogin($mysqli);

    ?>
    <body>
        <?php require_once("partials/navbar.php"); ?>
        <main>
            <div class="page-wrap">
                <div class="container">
                    <section id="decks-list">
                        
                        <h1 class="decks-heading">Decks</h1>
                        
                        <div class="text-center">
                            <?php $decks = $user->getDecks($mysqli) ?>
                            <?php if ($decks)  { ?>
                                <ul class="deck-list">
                                    <?php foreach ($decks as $deck) { ?>
                                        <li class="deck-list__item border-rad-1 text-start p-2 mb-2">
                                            <h4>
                                                <a href=""> 
                                                    <?php echo $deck['deck_title'] ?> 
                                                </a>
                                            </h4>
                                            <?php echo $deck['deck_description'] ? "<span>" . $deck['deck_description'] . "</span>" : '' ?>
                                            
                                        </li> 
                                    <?php } ?>
                                </ul>

                            <?php } else { ?>
                                <p class="mb-3" style="font-size: 1.5rem;">
                                    <strong>No decks to see here!</strong>
                                </p>
                            <?php } ?>

                            <button class="btn c-btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                Add new Deck
                            </button>
                
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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