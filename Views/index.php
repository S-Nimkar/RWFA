<?php
    // Initialize the session
    session_start();
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    require "../Scripts/config.php";
    require "../Scripts/index_script.php";
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
    <head>
        <?php include('../Views/meta_head.php'); ?>
        <title>RWFA</title>
    </head>
    <body class="d-flex flex-column h-100 o-white-max">
        <section name="header">
        <?php include('../Views/index_header.php'); ?>
        </section>
        <main role="main" class="flex-shrink-0 align-content-center">
            <div class="container d-blue-min">
                <h2 class="mt-3 p-1">Welcome <b><?php echo htmlspecialchars($_SESSION["fname"]), " ", htmlspecialchars($_SESSION["sname"]), ". "; ?></b></h2>
                <h4 class="mt-0 p-1">Your most recent activity:</h4>
                <div class="row">
                    <div class="col-sm-4 p-4">
                        <div class="card text-center">
                            <div class="card-header">
                                Activity Tracker
                            </div>
                            <div class="card-body">
                                <p class="card-text">Reflective writing entries from the last 7 days:</p>
                                <?php 
                                    if ($DayTotal) {
                                        echo "
                                    <h1 class=\"card-title\"> $DayTotal </h1>
                                    ";
                                    } else {
                                        echo "
                                    <h4 class=\"card-title\"> No Recent Entries. </h4>
                                    ";
                                    }
                                    switch (true) {
                                        case ($DayTotal>20):
                                            echo "You're on fire, more than 20 entries in this past week.";
                                            break;
                                        case ($DayTotal>14):
                                            echo "At least twice a day, great work!";
                                            break;
                                        case ($DayTotal>6):
                                            echo "At least once a day, keep it up!";
                                            break;
                                        case ($DayTotal>0):
                                            echo "Keep working on those entries!";
                                            break;                    
                                    }
                                    ?>                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 p-4">
                        <div class="card text-center">
                            <div class="card-header">
                                Latest Peice of Reflective Writing
                            </div>
                            <?php
                            if ($recentEntryInfo) {
                            echo"
                                <div class=\"card-body\">
                                <div class=\"d-flex flex-column text-left\">
                                <h6 class=\"card-title m-0\">Journal: $journalName</h6>
                                <p class=\"card-text\">$RWEAgenda</p>
                                </div>
                                <hr>
                                <p class=\"card-text text-center my-2\">$RWEEntry</p>
                                <hr>
                                <a href=\"../Views/journal_view.php?ID=$journalID#$rweRecentID\" class=\"btn d-blue-btn-primary\">View Feedback</a>
                                </div>
                                <div class=\"card-footer text-muted\">
                                Last updated: $RWERecord
                                </div>
                                ";
                            } else {
                            echo"
                              <div class=\"card-body\">
                              <h6 class=\"card-title\">No recent journal entry!</h6>
                              <p class=\"card-text\">Create a new journal to get started.</p>
                              </div>
                            ";
                          }
                          ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-3 mx-1 mb-0 d-flex flex-row align-items-center">
                    <h2 class="p-1">Journals</h2>
                    <button class="btn d-blue-btn-primary p-1 h-75" type="button" data-toggle="collapse" data-target="#journalCollapse" aria-expanded="false" aria-controls="journalCollapse">
                    &nbsp;?&nbsp; 
                    </button>
                    <a href="../Views/journal_new.php" class="btn d-blue-btn-primary p-2 h-25 ml-auto" type="button">
                    New Journal
                    </a>
                </div>
                <div class="collapse" id="journalCollapse">
                    <div class="card card-body m-3">
                        <p>A journal is a folder to keep your reflective writing entries in. You can have as many journals as you need to organise your reflective writing entries</p>
                    </div>
                </div>
                <div class="row mx-1 mb-0 mt-0">
                    <h3 class="p-1">Current Journals</h3>
                </div>
                <?php 
                    $min = count($activeIDData);
                    for($i = 0; $i < $min; $i++) {
                        $val = $activeIDData[$i];
                        if (!$activeLastEntryData[$val]) {
                            $activeLastEntryData[$val] = "No entries";
                            $activeEntryCount[$val] = "0";
                        }
                        echo "
                        <div class=\"card container p-3 mt-4 mb-4 card-body\">
                            <div class=\"mx-2 mt-2 row flex-md-row d-flex justify-content-left\">
                                <h4 class=\"m-0\">$activeNameData[$i]</h4>
                            </div>
                            <div class=\"flex-column flex-sm-row d-flex justify-content-between align-items-center mx-2 my-4 my-sm-3\">
                                <h6 class=\"mt-2\">Entries: $activeEntryCount[$val]</h6>
                                <a href=\"../Views/journal_view.php?ID=$val\" class=\"btn d-blue-btn h-25\">View</a>
                            </div>
                            <div class=\"ml-2 mr-2 row flex-md-row d-flex justify-content-between\">
                                <h6 class=\"text-muted\">Created: $activeLastRecordData[$i]</h6>
                                <h6 class=\"text-muted\">Last Updated: $activeLastEntryData[$val]</h6>
                            </div>
                        </div>
                        ";
                    }
                    ?>
                    <hr>
                <div class="row p-3 d-flex justify-content-center">
                    <button class="btn d-blue-btn-primary p-2 h-25 mb-2" type="button" data-toggle="collapse" data-target="#compltedJournalCollapse" aria-expanded="false" aria-controls="compltedJournalCollapse">
                    View Completed Journals 
                    </button>
                </div>
                <div class="collapse" id="compltedJournalCollapse">
                    <?php 
                        $min = count($inactiveIDData);
                        if ($min) {
                            for($i = 0; $i < $min; $i++) {
                            $val = $inactiveIDData[$i];
                            echo "
                            <div class=\"card container p-3 mt-4 mb-4 card-body\">
                                <div class=\"mx-2 mt-2 row flex-md-row d-flex justify-content-left\">
                                    <h4 class=\"m-0\">$inactiveNameData[$i]</h4>
                                </div>
                                <div class=\"flex-column flex-sm-row d-flex justify-content-between align-items-center mx-2 my-4 my-sm-3\">
                                    <h6 class=\"mt-2\">Total Entries: $inactiveEntryCount[$val]</h6>
                                    <a href=\"../Views/journal_view.php?ID=$val\" class=\"btn d-blue-btn h-25\">View</a>
                                </div>
                                <div class=\"ml-2 mr-2 row flex-md-row d-flex justify-content-between\">
                                    <h6 class=\"\">Created: $inactiveLastRecordData[$i]</h6>
                                    <h6 class=\"\">Last Updated: $inactiveLastEntryData[$val]</h6>
                                </div>
                            </div>
                            ";
                            }
                        } else {
                            echo"
                            <div class=\"card text-center container col-sm-4 p-3 mt-2 mb-4 card-body\">
                                <h5 class=\"m-3 text-center\">
                                No completed journals
                                </h5>
                            </div>
                            ";
                        }
                        ?>
                </div>
                
            </div>
        </main>
        <footer class="footer mt-auto py-3 d-blue-max">
             <?php include('../Views/meta_footer.php'); ?>
        </footer>
        <!-- JS, Popper.js, and jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </body>
</html>