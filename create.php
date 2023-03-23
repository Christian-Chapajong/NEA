<!doctype html>
<html lang="en">
    <?php
        session_start();

        require_once("partials/head.php");
        require_once("partials/functions.php");

        $user = checkLogin($mysqli);

        // If upload button is clicked ...
        if (isset($_POST['upload'])) {

            // save the filename of the uploaded image
            $filename = $_FILES["upload_img"]["name"];
            // temp name for where the image is stored after upload
            $tempname = $_FILES["upload_img"]["tmp_name"];
            // the image side that has been selected
            $side = $_POST['side'];
            $folder = "./images/" . $filename;
            $image_id = createID(5);

            // if the image side is front
            if ($side == "front") {
                $on_front = true;
            } else {
                $on_front = false;
            }

            // Get all the submitted data from the form
            $sql = "INSERT INTO images (image_id, filename, on_front) VALUES (?, ?, ?)";

            // if the prepare statement is successful
            if( $stmt = $mysqli->prepare($sql) ) {
                $_SESSION['image_id'] = $image_id;
                // specify each data type and bind the paramaters of the sql statement with the variable
                $stmt->bind_param('sss', $image_id, $filename, $on_front);
                $stmt->execute();

            } else { // if the prepare statement is unsuccessful, output the error
                echo $mysqli->errno . ' ' . $mysqli->error;
            }

            // move the uploaded image into the folder: images
            move_uploaded_file($tempname, $folder);
        }

        // if a new colour is saved...
        if (isset($_POST['save_colour'])) {
            //save both colours into variables
            $front_colour = $_POST['front_colour'];
            $back_colour = $_POST['back_colour'];
            $_SESSION['front_colour'] = $front_colour;
            $_SESSION['back_colour'] = $back_colour;

        }

        // if a flashcard is added...
        if( isset($_POST['add_card']) && (isset($_POST['flashcard_front']) || isset($_POST['flashcard_back'])) ) {
            $deck_id = $_GET['deck_id'];
            $flashcard_front = $_POST['flashcard_front'];
            $flashcard_back = $_POST['flashcard_back'];
            $tags = $_POST['tags'];

            $flashcard_id = createID(5);

            // if front or back colour is set
            if (isset($_SESSION['image_id'])) {
                if (isset($_SESSION['front_colour']) || isset($_SESSION['back_colour'])) {
                    // create a query which inserts a new row into flashcards with colours
                    $sql = "INSERT INTO flashcards (flashcard_id, deck_id, flashcard_front, flashcard_back, image_id, front_colour, back_colour) VALUES (?, ?, ?, ?, ?, ?, ?)";
                } else {
                    $sql = "INSERT INTO flashcards (flashcard_id, deck_id, flashcard_front, flashcard_back, image_id) VALUES (?, ?, ?, ?, ?)";
                }
            } elseif (isset($_SESSION['front_colour']) || isset($_SESSION['back_colour'])) {
                $sql = "INSERT INTO flashcards (flashcard_id, deck_id, flashcard_front, flashcard_back, front_colour, back_colour) VALUES (?, ?, ?, ?, ?, ?)";
            } else {
                // create a query which inserts a new row into flashcards without colours
                $sql = "INSERT INTO flashcards (flashcard_id, deck_id, flashcard_front, flashcard_back) VALUES (?, ?, ?, ?)";
            }
            
            // if the prepare statement is successful
            if( $stmt = $mysqli->prepare($sql) ) {
                // if the front or back colour is set 
                if (isset($_SESSION['image_id'])) {
                    if (isset($_SESSION['front_colour']) || isset($_SESSION['back_colour'])) {
                        // specify each data type and bind the paramaters of the sql statement with the variables
                        $stmt->bind_param('sssssss', $flashcard_id, $deck_id, $flashcard_front, $flashcard_back, $_SESSION['image_id'], $_SESSION['front_colour'], $_SESSION['back_colour']);
                        unset($_SESSION['front_colour']);
                        unset($_SESSION['back_colour']);   
                    } else {
                        $stmt->bind_param('sssss', $flashcard_id, $deck_id, $flashcard_front, $flashcard_back, $_SESSION['image_id']);
                    }
                    unset($_SESSION['image_id']);
                } elseif (isset($_SESSION['front_colour']) || isset($_SESSION['back_colour'])) {
                    $stmt->bind_param('ssssss', $flashcard_id, $deck_id, $flashcard_front, $flashcard_back, $_SESSION['front_colour'], $_SESSION['back_colour']);

                } else {
                    $stmt->bind_param('ssss', $flashcard_id, $deck_id, $flashcard_front, $flashcard_back);
                }

                $stmt->execute();

            } else { // if the prepare statement is unsuccessful, output the error
                echo $mysqli->errno . ' ' . $mysqli->error;
            }

            

            if ($tags) {
                $tagsArray = explode(',', $tags); //convert the string into an array with each element being a tag

                // for each tag in the array
                foreach ($tagsArray as $tag_name) {
                    $tag_id = createID(5);
                    // create a query which inserts a new row into tags
                    $sql = "INSERT INTO tags (tag_id, flashcard_id, tag_name) VALUES (?, ?, ?)";

                    // if the prepare statement is successful
                    if( $stmt = $mysqli->prepare($sql) ) {
                        // specify each data type and bind the paramaters of the sql statement with the variables
                        $stmt->bind_param('sss', $tag_id, $flashcard_id, $tag_name);
                        $stmt->execute();

                    } else { // if the prepare statement is unsuccessful, output the error
                        echo $mysqli->errno . ' ' . $mysqli->error;
                    }

                }
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
                            <a href="decks.php">
                                <button type="button" name="create_deck" class="btn btn-primary">Done</button>

                            </a>
                        </div>
                        <span class="current-deck">
                            <span class="current-deck__heading">Current deck: </span>
                            <select name="selected_deck_id" class="form-select d-inline-block selected-deck-form" onchange="location = this.value;">
                                <?php
                                    $decks = $user->getDecks($mysqli);
                                    foreach ($decks as $deck) {
                                        if ($deck['deck_id'] == $_GET['deck_id']) {
                                            echo "<option value='create.php?deck_id={$deck['deck_id']}' selected> {$deck['deck_title']} </option>";
                                        } else {
                                            echo "<option value='create.php?deck_id={$deck['deck_id']}'> {$deck['deck_title']} </option>";
                                        }
                                    }
                                ?>
                            </select>
                        </span>
                    </section>

                    <section id="add-card">
                        <h3 class="mb-2">Add Card</h3>
                        <div class="card-generator-container">
                            <div class="card-generator d-flex flex-column">
                                <div class="card-generator__hotbar">
                                    <div class="hotbar-bg justify-content-center align-items-center text-center mx-auto">
                                        <ul class="hotbar__icons">
                                            <li id="uploadImageButton" class="hotbar__icon" >
                                                <i class="fa-regular fa-images fa-2x" ></i>
                                            </li>
                                            <li class="hotbar__icon">
                                                <div class="dropdown">
                                                    <i class="fa-solid fa-palette fa-2x" id="paletteDropdown" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                    <ul class="dropdown-menu py-3 px-2" aria-labelledby="paletteDropdown">
                                                        <form method="POST" id="colourPalette">
                                                            <div class="mb-2">
                                                                <input type="color" id="front_colour" name="front_colour" value="<?php echo isset($front_colour) ? $front_colour : '#000000' ?>">
                                                                <label class="align-top" for="head">Front</label>
                                                            </div>
                                                            <div class="mb-2">
                                                                <input type="color" id="back_colour" name="back_colour" value="<?php echo isset($back_colour) ? $back_colour : '#000000' ?>">
                                                                <label class="align-top" for="head">Back</label>
                                                            </div>
                                                            <div class="text-center">
                                                                <button name="save_colour" class="btn btn-outline-primary c-btn" type="submit">Save</button>
                                                            </div>


                                                        </form>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-generator__main py-4 px-2 mx-auto">
                                    <form id="createCardForm" method="POST">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="front-addon">Front</span>
                                            <input type="text" id="flashcard_front" name="flashcard_front" class="form-control p-3" aria-label="card-front" placeholder="What is the captial of England?">
                                        </div>
                                        <div class="input-group mb-5">
                                            <span class="input-group-text" id="back-addon">Back</span>
                                            <input type="text" id="flashcard_back" name="flashcard_back" class=" form-control p-3" aria-label="card-front" placeholder="London">
                                        </div>
                                        <div class="input-group mt-3 mb-3">
                                            <span class="input-group-text" id="back-addon">Tags</span>
                                            <input id="flashcard_tags" type="text" name="tags" class="form-control p-1" placeholder="geography, capital-cities (comma-separated)" >
                                        </div>
                                        <label for="flashcard_tags" class="form-label"></label>
                                        <?php if (isset($filename)) { ?>
                                            <div class="row mb-5">
                                                <h3>Image</h3>
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="uploaded-img">
                                                        <img src="./images/<?php echo $filename ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <p>
                                                        <strong>Side:</strong>
                                                        <?php echo isset($on_front) && $on_front == true ? "Front" : "Back" ?>
                                                    </p>
                                                </div>

                                            </div>

                                        <?php } ?>
                                        <div class="col-12 text-center mb-5">
                                            <button name="add_card" class="btn btn-outline-success c-btn p-3 add-btn" onclick="submit()">Add</button>
                                        </div>
                                       

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-12 text-center">
                            <button type="submit" name="generate_card" class="btn btn-secondary c-btn p-3 ">Generate card</button>
                        </div>           -->
                    </section>
                    <!-- Upload Image Modal -->
                    <div class="modal fade" id="uploadImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploadImageLabel" aria-hidden="true">
                        <div class="modal-dialog absolute-center">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Upload Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form method="POST" id="uploadImageForm" class="uploadForm" action="" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input class="form-control" type="file" name="upload_img" value="" required>
                                    </div>
                                    <div class="mt-3">
                                        <input type="radio" id="front" name="side" value="front" required>
                                        <label for="front"> Front </label>
                                    </div>
                                    <div class="mt-2">
                                        <input type="radio" id="back" name="side" value="back" required>
                                        <label for="back"> Back </label>
                                    </div>
                                </form>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button class="btn c-btn btn-outline-primary mt-4 mb-3 " form="uploadImageForm" type="submit" name="upload">Upload</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php require_once("partials/scripts.php") ?>
        <script>
            // when the page has loaded...
            document.addEventListener('DOMContentLoaded', function () {

                // if a filename already exists, set imageAdded to true, else false
                var imageAdded = "<?php echo isset($filename) ? true : false  ?>";
                // save the upload image modal as a constant 
                const imgModal = $("#uploadImage");
                // save the upload image button as a constant
                const uploadImgBtn = $("#uploadImageButton");

                // when the upload image button is clicked...
                uploadImgBtn.click(function() {
                    if (imageAdded) {
                        // alert the user that an image has already been added
                        alert("Image already added.");
                    } else {
                        // if no image has been added, display the modal
                        imgModal.modal('show');
                    }
                });


                // save front colour input as a constant
                const frontColourInput = document.getElementById("front_colour");
                // if the a new input is given to front colour...
                frontColourInput.addEventListener("input", function() {
                    // save the current value of the input as a 'let' variable
                    let colour = frontColourInput.value;
                    // change the colour styling of flashcard_front 
                    document.getElementById("flashcard_front").style.color = colour;
                })

                // save back colour input as a constant
                const backColourInput = document.getElementById("back_colour");
                // if the a new input is given to back colour...
                backColourInput.addEventListener("input", function() {
                    // save the current value of the input as a 'let' variable
                    let colour = backColourInput.value;
                    // change the colour stlying of flashcard_back
                    document.getElementById("flashcard_back").style.color = colour;
                })
            });

        </script>
  </body>
</html>