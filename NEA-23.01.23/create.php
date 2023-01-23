<!doctype html>
<html lang="en">
    <?php
        session_start();

        require_once("partials/head.php");
        require_once("partials/functions.php");

        $user = checkLogin($mysqli);

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            //something was posted
            $deck_title = $_POST['deck_title'];
            // if deck description is filled then save into variable
            $_POST['deck_description'] ? $deck_description = $_POST['deck_description'] : '';

            // add deck title to session so that it can be used on other pages
            $_SESSION['deck_title'] = $deck_title;

            $deck_id = createID(5);
            $user_id = $user->getUserId(); 
            // create a query which inserts a new row into decks
            $sql = "INSERT INTO decks (deck_id, user_id, deck_title, deck_description) VALUES (?, ?, ?, ?)";

            // if the prepare statement is successful 
            if( $stmt = $mysqli->prepare($sql) ) {
                // specify each data type and bind the paramaters of the sql statement with the variables,
                $stmt->bind_param('ssss', $deck_id, $user_id, $deck_title, $deck_description);
                $stmt->execute();
                
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
                    <section id="title-and-description">
                        <div class="d-flex justify-content-between">
                            <h1>Create</h1>
                            <button type="button" name="create_deck" class="btn btn-primary">Done</button>
                        </div>
                        <span class="current-deck">
                            <span class="current-deck__heading">Current deck: </span>
                            <?php echo $_SESSION['deck_title'] ?>
                        </span>
                        <!-- <p class="mb-3"><strong>Add a new deck</strong></p>
                        <form method="">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="deck_title" class="form-control border-rad-1" id="title" placeholder="A-level Computer Science...">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control border-rad-1" id="description" rows="3" placeholder="A deck which covers all the topics in the OCR syllabus..."></textarea>
                            </div>
                        </form> -->
                    </section>
                    
                    <section id="add-card">
                        <h3 class="mb-2">Add Card</h3>
                        <div class="card-generator-container">
                            <div class="card-generator d-flex flex-column">
                                <div class="card-generator__hotbar">
                                    <div class="hotbar-bg justify-content-center align-items-center text-center mx-auto">
                                        <ul class="hotbar__icons">
                                            <li>
                                            <i class="fa-solid fa-microphone fa-2x"></i>
                                            </li>
                                            <li>
                                            <i class="fa-regular fa-images fa-2x"></i>                               
                                            </li>
                                            <li>
                                            <i class="fa-solid fa-palette fa-2x"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-generator__main py-4 px-2 mx-auto">
                                    <form method="">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="front-addon">Front</span>
                                            <input type="text" class="form-control p-3" aria-label="card-front" aria-describedby="front-addon">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="back-addon">Back</span>
                                            <input type="text" class="form-control p-3" aria-label="card-front" aria-describedby="back-addon">
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" name="add_card" class="btn btn-outline-success c-btn p-3">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" name="generate_card" class="btn btn-secondary c-btn p-3 ">Generate card</button>
                        </div>          
                    </section>
                </div>
            </div>
        </main>
        <?php require_once("partials/scripts.php") ?>
  </body>
</html>