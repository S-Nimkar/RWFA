<?php
    // Initialize the session
    session_start();
     
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    require '../Scripts/journal_view_script.php';
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
    <head>
        <?php include('/Views/meta_head.php'); ?>
        <title>New Journal</title>
    </head>
    <body class="d-flex flex-column h-100 o-white-max">
        <section name="header">
            <div class="o-white-max d-flex flex-column flex-md-row align-items-center p-4 px-md-4 mb-3 justify-content-between">
                <a href="../Views/welcome.php">
                <img src="../Styles/header-logo.png" class="img-fluid header-img">
                </a>
                <nav class="my-4 my-md-0 mr-md-3 right-nav">
                    <a class="btn d-blue-btn" href="../Scripts/logout.php">Logout</a>
                </nav>
            </div>
            <div class="lower-header d-blue-max d-flex flex-column flex-md-row align-items-center p-2 px-md-4 mb-3 border-bottom shadow-sm">
            </div>
        </section>
        <main role="main" class="flex-shrink-0 align-content-center">
            <div class="container d-blue-min">
                <div class="row d-flex flex-row justify-content-between">
                    <h2 class="ml-4 mt-4"> <?php echo"$journalName"?> </h2>
                    <?php echo"<form method=\"post\" action=\"../Scripts/downloadJournal.php?&journalID=$journalid\">";?>
                    <input type="submit" class="btn d-blue-btn-primary m-4" value ="Download" onclick="return confirm('Are you sure you want to download the journal?');">
                    </a>
                    </form>
                </div>
                <div class="row d-flex flex-row">
                    <h4 class="ml-4"> <?php echo"$journalTopic"?> </h4>
                    <button class="btn d-blue-btn p-1 ml-2 mt-0" type="button" data-toggle="collapse" data-target="#journalCollapse" aria-expanded="false" aria-controls="journalCollapse">
                    &nbsp;Goal&nbsp; 
                    </button>
                    <div class="collapse" id="journalCollapse">
                        <div class="card card-body m-3">
                            <p> <?php echo"$journalGoal"; ?></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row d-flex flex-row justify-content-center">
                    <a href="../Views/rwe_new.php?journalID=<?php echo"$journalid"; ?>" class="btn d-blue-btn-primary mt-1 mb-2" type="button">
                    New Reflective Writing Entry
                    </a>
                </div>
                <h5 class="ml-4 mt-1"> Reflective Writing Entries </h5>
                <?php 
                    $min = count($rweAgenda);
                    if (!$rweAgenda) {
                        echo"<h5 class=\"m-3\">No reflective writing entries have been written yet!</h5>";
                    }
                    for($i = 0; $i < $min; $i++) {
                        echo "
                        <div class=\"card container p-3 mt-4 mb-4 card-body\">
                            <div class=\"ml-2 mr-2 row flex-md-row d-flex justify-content-left\">
                                <h5 class=\"ml-3\">$rweAgenda[$i]</h5>
                            </div>
                            <div class=\"m-2 row flex-md-row d-flex justify-content-left\">
                                <p class=\"col-sm-10\">$rweEntry[$i]</p>
                            </div>
                            <div class=\"ml-2 mr-2 row flex-md-row d-flex justify-content-between\">
                                <div class=\"dropdown\">
                                  <button class=\"btn d-blue-btn  dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                    Options
                                  </button>
                                  <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\">
                                    <form method=\"post\" action=\"../Scripts/deleteRWE.php?rweID=$rweid[$i]&journalID=$journalid\">
                                        <input type=\"submit\" class=\"dropdown-item red\" onclick=\"return confirm('Are you sure you want to delete?');\" value=\"Delete\"></input>
                                    </form>
                                  </div>
                                </div>
                                <h6 class=\"text-muted\">Last updated: $rweRecord[$i]</h6>
                            </div>
                        </div>
                        ";
                    }
                    ?>
            </div>
        </main>
        <footer class="footer mt-auto py-3 d-blue-max">
            <div class="container o-white-min d-flex flex-column flex-md-row align-items-center justify-content-between">
                <span>University of Sussex - 2020</span>
                <span>Created by Sumedh Nimkar</span>
            </div>
        </footer>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </body>
</html>