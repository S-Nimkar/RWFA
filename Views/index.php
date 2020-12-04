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
        <title>Reflect with me</title>
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
                                            echo "You're on fire, more than 20 in this past week.";
                                            break;
                                        case ($DayTotal>14):
                                            echo "At least twice a day, great work!";
                                            break;
                                        case ($DayTotal>6):
                                            echo "At least once a day, keep submitting!";
                                            break;
                                        case ($DayTotal>0):
                                            echo "Keep working on those entries, try and create one a week.";
                                            break;                    
                                    }
                                    ?>                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 p-4">
                        <div class="card text-center">
                            <div class="card-header">
                                Latest Journal Entry
                            </div>
                            <?php
                                if ($recentEntryInfo) {
                                  echo"
                                  <div class=\"card-body\">
                                      <h6 class=\"card-title\">Journal Name: $journalName</h6>
                                      <h6 class=\"card-title\">Topic: $journalTopic</h6>
                                      <p class=\"card-text\">From a $RWEAgenda; " , substr($RWEEntry, 0 , 200) , "...</p>
                                      <a href=\"../Views/journal_view.php?ID=$journalID\" class=\"btn d-blue-btn-primary\">View Journal</a>
                                  </div>
                                  <div class=\"card-footer text-muted\">
                                      Last editied: $RWERecord
                                  </div>
                                  ";
                                } else {
                                  echo"
                                  <div class=\"card-body\">
                                      <h6 class=\"card-title\">No recent journal entry!</h6>
                                      <p class=\"card-text\">Create a new journal to get started.</p>
                                      <a href=\"../Views/journal_new.php\" class=\"btn d-blue-btn-primary\">New Journal</a>
                                  </div>
                                  ";
                                }
                                ?>
                        </div>
                    </div>
                    <div class="col-sm-4 p-4">
                        <div class="card text-center">
                            <div class="card-header">
                                Journal Goals
                            </div>
                            <div class="card-body">
                                <p class="card-text">Some goals from your recent journals.</p>
                                <?php
                                    if ($recentGoalData) { 
                                        $min = count($recentGoalData);
                                        for($i = 0; $i < $min; $i++) {
                                            echo "<p class=\"card-text\"> Journal Name: $recentNameData[$i],<br> $recentGoalData[$i]</p>
                                            ";
                                        }
                                    } else {
                                        echo "<p class=\"card-text\">No recent goals, Create a new journal.</p>";
                                    }
                                    ?>
                            </div>
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
                        <p>Journals are used to categorise and manage your reflective writing entries. Each journal defines the narrative of the reflective writing entries and reflects a certain area that is defined by you in the topic section. You can manage your journals below. See your current journals and the completed journals.</p>
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
                                <h4 class=\"\">$activeNameData[$i]</h4>
                            </div>
                            <h5 class=\"ml-2\">$activeTopicData[$i]</h5>
                            <div class=\"flex-column flex-sm-row d-flex justify-content-between align-items-center mx-2 my-4 my-sm-3\">
                                <h6 class=\"col-sm-8 p-0\">Goal: $activeGoalData[$i]</h6>
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
                                    <h4 class=\"\">$inactiveNameData[$i]</h4>
                                </div>
                                <h5 class=\"ml-2\">$inactiveTopicData[$i]</h5>
                                <div class=\"flex-column flex-sm-row d-flex justify-content-between align-items-center mx-2 my-4 my-sm-3\">
                                    <h6 class=\"col-sm-8 p-0\">Goal: $inactiveGoalData[$i]</h6>
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