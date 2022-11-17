<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Font Awesome 5 -->
    <script src="https://kit.fontawesome.com/baf9f47d90.js" crossorigin="anonymous"></script>
    <!-- Styling -->
    <link rel="stylesheet" href="/assets/css/main.css">



    <title>Flashcard Web App</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Flashcards</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <div class="navbar-nav">
            <div class="">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </div>
            <div class="">
              <a class="nav-link" href="#">Search</a>
            </div>
            <div class="me-auto">
              <a class="nav-link" href="#">Create</a>
            </div>
            <div class="">
              <a class="nav-link authentication-link" href="#">Login</a>
            </div>
            <div class="">
              <a class="nav-link authentication-link" href="#">Signup</a>
            </div>
          </u>
      </div>
    </nav>
    
    <main>
      <div class="page-wrap">
        <div class="container">
          <section id="title-and-description">
            <div class="d-flex justify-content-between">
              <h1>Create</h1>
              <button type="button" name="create_deck" class="btn btn-primary">Done</button>
            </div>
            <p class="mb-3"><strong>Add a new deck</strong></p>
            <div class="mb-3">
              <form method="">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="deck_title" class="form-control border-rad-1" id="title" placeholder="A-level Computer Science...">
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control border-rad-1" id="description" rows="3" placeholder="A deck which covers all the topics in the OCR syllabus..."></textarea>
                </form>
            </div>
          </section>
          
          <section id="add-card">
            <h3 class="mb-2">Add Card</h3>           
            <div class="card-generator d-flex flex-column">
              <div class="card-generator__hotbar">
                <div class="hotbar-bg text-center mx-auto">
                  <ul class="hotbar__icons">
                    <li>
                      <i class="fa-regular fa-microphone"></i>
                    </li>
                    <li>
                      <i class="fa-regular fa-images fa-2x"></i>                               </li>
                    <li>
                      <i class="fa-regular fa-palette fa-2x"></i>
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
                    <button type="submit" name="add_card" class="btn btn-outline-success btn-add-card p-3">Add</button>
                  </div>
                </form>
              </div>
            </div>
            </div>
            
          </section>
           
          
          
        </div>
      </div>

      
    </main>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>