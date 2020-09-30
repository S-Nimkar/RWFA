<?php
    // Initialize the session
    session_start();
     
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    require '../Scripts/journal_new_script.php';
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
                <div class="row d-flex flex-row justify-content-center">
                <h2 class="mt-3 p-1">Create a new Journal</h2>
                </div>
                <div class="row d-flex justify-content-center">
                <div class="card col-sm-8 m-3">
                    <h4 class="pl-4 pt-4">Fill in the journal details below</h4>
                    <form class="p-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group row <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label for="journalName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="journalName" placeholder="Enter a name for your Journal" value="<?php echo $name; ?>">
                                <span class="help-block"><?php echo $name_err; ?></span>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($topic_err)) ? 'has-error' : ''; ?>">
                            <label for="journalTopic" class="col-sm-2 col-form-label">Topic</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="journalTopic" placeholder="Enter a topic that best fits the Journal" value="<?php echo $topic; ?>">
                                <span class="help-block"><?php echo $topic_err; ?></span>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($goal_err)) ? 'has-error' : ''; ?>">
                            <label for="journalGoal" class="col-sm-2 col-form-label">Goal</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control journal-text-area" name="journalGoal" placeholder="Enter a short description of the goal that best describes the overreaching aim of the Journal and the writing you aim to create." value="<?php echo $goal; ?>"></textarea>
                                <span class="help-block"><?php echo $goal_err; ?></span>
                            </div>
                        </div>
                        <div class="form-group row d-flex justify-content-center">
                            <input type="submit" class="btn d-blue-btn-primary" value="Create">
                        </div>
                    </form>
                </div>
                </div>
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