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
        <?php include('../Views/meta_head.php'); ?>
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
                <div class="d-flex flex-row justify-content-between mt-4 mb-2">
                    <h2> <?php echo"$journalName"?> </h2>
                    <!-- <?php echo"<form method=\"post\" action=\"../Scripts/downloadJournal.php?&journalID=$journalid\">";?>
                    <input type="submit" class="btn d-blue-btn-primary m-4" value ="Download" onclick="return confirm('Are you sure you want to download the journal?');">
                    </a> 
                    </form> -->
                </div>
                <div class="d-flex flex-row flex-wrap align-items-center justify-content-left">
                    <h4 class="my-1"> <?php echo"$journalTopic"?> </h4>
                    <button class="btn d-blue-btn p-1 ml-2 mt-0" type="button" data-toggle="collapse" data-target="#journalCollapse" aria-expanded="false" aria-controls="journalCollapse">
                    &nbsp;Goal&nbsp; 
                    </button>
                </div>
                <div class="collapse ml-auto mr-auto" id="journalCollapse" style="width: fit-content">
                    <div class="card card-body mt-3">
                        <p> <?php echo"$journalGoal"; ?></p>
                    </div>
                </div>
                <hr>
                <div class="row d-flex flex-row justify-content-center">
                    <a href="../Views/rwe_new.php?journalID=<?php echo"$journalid"; ?>" class="btn d-blue-btn-primary mt-1 mb-2" type="button">New Reflective Writing Entry</a>
                </div>
                <hr>
                <h5 class="mt-1"> Reflective Writing Entries </h5>
                <?php 
                    $min = count($rweAgenda);
                    if (!$rweAgenda) {
                        echo"<h5 class=\"mt-1\">No reflective writing entries have been written yet!</h5>";
                    }
                    for($i = 0; $i < $min; $i++) {
                        echo "
                        <div class=\"card container p-3 mt-4 mb-4 card-body\">
                            <div class=\"flex-sm-row d-flex justify-content-left\">
                                <h5 class=\"ml-2\">Writing Agenda: $rweAgenda[$i]</h5>
                            </div>
                            <div class=\"m-4 flex-md-row d-flex justify-content-center\">
                                <p class=\" m-0\">";
                        echo nl2br($rweEntry[$i]);
                        echo"</p>
                            </div>
                            <hr>
                            ";
                        if ($rweFeedbackID[$i] == "-1") {
                            echo "
                            <div class=\"d-flex flex-row justify-content-center\">
                                <a href=\"../Scripts/rwe_generatefeedback.php?journalID=$journalid&rweID=$rweid[$i]\" class=\"btn d-blue-btn-primary mt-1 mb-2 w-25\" type=\"button\">
                                    Generate Feedback 
                                </a>
                            </div>
                            ";
                        } else {
                            $sql = "SELECT WordCount, Positive, Negative FROM RWEFeedback WHERE ID = $rweFeedbackID[$i]";
                                if ($result = mysqli_query($link, $sql)) { 
                                    $rwefWC = $rwefP = $rwefN = "";
                                    while ($row = mysqli_fetch_row($result)) {
                                        $rwefWC = $row[0];
                                        $rwefP = $row[1];
                                        $rwefN = $row[2];
                                    }
                                    mysqli_free_result($result);
                                }
                            if ($rwefWC > 50) {
                                $randKey = array_rand($WCCommentPos, 1);
                                $wordcountComment = $WCCommentPos[$randKey]; 
                            } else {
                                $randKey = array_rand($WCCommentNeg, 1);
                                $wordcountComment = $WCCommentNeg[$randKey]; 
                            }
                            if (empty($rwefP)) {
                                $PCOM = array("This entry doesn't include any postive aspects of reflective writing, make sure you check out skills hub for some more information on how to write a reflective peice of writing.");
                            } else {
                                $PCOM = explode("|", $rwefP);
                            }

                            if (empty($rwefN)) {
                                $NCOM = array("The perfect peice of writing! For a further evaluation, look into the skills hub and see what else could be included.");
                            } else {
                                $NCOM = explode("|", $rwefN);
                            }
                            echo "
                            <div class=\"card container p-3 mt-4 mb-4 card-body\">
                                <div class=\"flex-sm-row d-flex justify-content-left\">
                                    <h5 class=\"ml-2\">Feedback</h5>
                                </div>
                                <div class=\"flex-column d-flex justify-content-center align-items-center\">
                                    <div class=\"feedback-container col-sm-8 wordcount-text\">
                                        <p class=\" m-0\">$wordcountComment</p>
                                    </div>
                                    <div class=\"feedback-container col-sm-8 poscomment-text\">
                                ";
                                foreach ($PCOM as $value) {
                                    echo "<p class=\" m-0\">$value</p>";
                                }
                            echo "
                                    </div>
                                    <div class=\"feedback-container col-sm-8 negcomment-text\">
                                ";
                                foreach ($NCOM as $value) {
                                    echo "<p class=\" m-0\">$value</p>";
                                }
                            echo "
                                    </div>
                                </div>
                            </div>    
                            ";
                            /*
                                Beige for word count + word count comment
                                
                            */
                        }

                        echo "
                            <hr>
                            <div class=\"flex-column flex-sm-row d-flex justify-content-between align-items-center\">
                                <div class=\"dropdown m-2\">
                                  <button class=\"btn d-blue-btn  dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                    Options
                                  </button>
                                  <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\">
                                    <form method=\"post\" action=\"../Scripts/deleteRWE.php?rweID=$rweid[$i]&journalID=$journalid\">
                                        <input type=\"submit\" class=\"dropdown-item red\" onclick=\"return confirm('Are you sure you want to delete?');\" value=\"Delete\"></input>
                                    </form>
                                  </div>
                                </div>
                                <h6 class=\"text-muted m-2\">Last updated: $rweRecord[$i]</h6>
                            </div>
                        </div>
                        ";
                    }
                    ?>
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