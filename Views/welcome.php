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
    <title>RWFA</title>
  </head>
  <body class="d-flex flex-column h-100 o-white-max">
    <section name="header">
      <?php include('../Views/login_header.php'); ?>
    </section>
    <main role="main" class="flex-shrink-0">
      <div class="container d-flex flex-row d-blue-min flex-wrap justify-content-center align-items-center my-3">
        <img src="../Styles/reflection-img.png" class="img-fluid col-12 col-sm-6 p-5">
        <div class="d-flex flex-column d-blue-min col-sm-6 pt-sm-3 pb-3">
          <h2 class="mt-3">A Reflective Writing Feedback Application.</h2>
          <h4><u>How to use</u></h4>
          <p class="my-1">Create a journal on a specific topic</p>
          <p class="my-1">After a learning activity (lecture, seminar, meeting with tutor, reading an article, day at work, etc.) reflect on the event and create an entry, saying what you learned, and setting goals for next time. Click on the help tab if you want some writing prompts</p>
          <p class="my-1">Submit your entry and review the feedback</p>
          <p class="my-1">Make regular entries to monitor your progress</p>
          <p class="my-1">For more information on reflective writing go to the <a href="http://www.sussex.ac.uk/skillshub/?id=476">Skills Hub</a></p>
        </div>
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