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
                            <?php if ($user->getDecks() > 0) { ?>
                                <!-- Output users decks -->
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
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary">Understood</button>
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