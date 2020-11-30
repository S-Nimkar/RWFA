<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" class="h-100">
  <head>
    <?php include('../Views/meta_head.php'); ?>
    <title>Reflect with me</title>
  </head>
  <body class="d-flex flex-column h-100 o-white-max">
    <section name="header">
      <div class="o-white-max d-flex flex-column flex-md-row align-items-center p-4 px-md-4 mb-3 justify-content-between">
        <a href="../Views/welcome.php">
        <img src="../Styles/header-logo.png" class="img-fluid header-img" >
        </a>
        <nav class="my-4 my-md-0 mr-md-3">
          <a class="btn d-blue-btn" href="../Views/login.php">Login</a>
          <a class="btn d-blue-btn" href="../Views/registration.php">Sign up</a>
        </nav>
      </div>
      <div class="lower-header d-blue-max d-flex flex-column flex-md-row align-items-center p-2 px-md-4 mb-3 border-bottom shadow-sm">
      </div>
    </section>
    <main role="main" class="flex-shrink-0 align-content-center">
      <div class="container d-blue-min">
        <h2 class="mt-3">Reflect with me: a reflective writing feedback application.</h2>
        <h4>A short introduction:</h4>
        <p>Reflective writing is the process of reviewing ones learning in a manner that is indicative of reflective thinking. It is a personal form of academic writing and as such is key to fully understanding learning. By performing a reflective writing task on a subject, the writer must succinctly write about the specific topic in a way that expresses their understanding and thoughts.
          <br><br>
        Providing an application that encourages the writer to continually improve on their reflective writing and to keep track of what they write about while also offering constructive, informative feedback in a friendly, approachable manner is the key aim of this web application.
        </p>
      </div>
    </main>

    <footer class="footer mt-auto py-3 d-blue-max">
      <?php include('../Views/meta_footer.php'); ?>
    </footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>