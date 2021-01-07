<?php
    // Initialize the session
    session_start();
     
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    $journalid = $_GET["journalID"];
    require_once "../Scripts/config.php";
    require_once "../Scripts/rwe_new_script.php";
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
    <head>
        <?php include('../Views/meta_head.php'); ?>
        <title>New Reflective Writing entry</title>
    </head>
    <body class="d-flex flex-column h-100 o-white-max">
        <section name="header">
            <?php include('../Views/index_header.php'); ?>
        </section>
        <main role="main" class="flex-shrink-0 align-content-center">
            <div class="container d-blue-min">
                <button class="btn d-blue-btn text-center mr-auto mt-2" onclick="history.go(-1);" style="height: fit-content;">Back </button>
                <div class="row d-flex flex-row justify-content-center align-items-center">
                <h2 class="mt-3 p-1">New Reflective Writing entry</h2>
                </div>
                <div class="row d-flex justify-content-center">
                <div class="card col-sm-8 m-3">
                    <form class="p-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="journalid" value="<?php echo"$journalid";?>">
                        <div class="form-group row <?php echo (!empty($agenda_err)) ? 'has-error' : ''; ?>">
                            <label for="agenda" class="col-sm-2 col-form-label">Agenda</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="agenda">
                                    <option>Lecture</option>
                                    <option>Seminar</option>
                                    <option>Workshop</option>
                                    <option>Independent Work</option>
                                    <option>Tutorial</option>
                                    <option>Assessment Draft</option>
                                    <option>Other</option>
                                </select>
                                <span class="help-block"><?php echo $agenda_err; ?></span>
                            </div>
                        </div>
                        <div class="form-group row <?php echo (!empty($entry_err)) ? 'has-error' : ''; ?>">
                            <div class="col-sm-12">
                                <textarea type="text" class="form-control rwe-text-area" name="entry" placeholder="Write your piece of reflective writing here" value="<?php echo $entry; ?>"></textarea>
                                <span class="help-block"><?php echo $entry_err; ?></span>
                            </div>
                        </div>
                        <div class="form-group flex-row d-flex justify-content-between">
                            <button class="btn d-blue-btn text-center" type="button" data-toggle="collapse" data-target="#journalCollapse" aria-expanded="false" aria-controls="journalCollapse">Help</button>
                            <input type="submit" class="btn d-blue-btn-primary" value="Create">
                        </div>
                        <div class="collapse ml-auto mr-auto mb-2" id="journalCollapse" style="width: fit-content">
                            <div class="mx-1 text-muted form-group flex-column d-flex text-center ">
                                <p><u>Some prompts to help you in your writing: </u></p><p>In the process of completing this assignment I learned … <br>What I realised about academic writing was … because <br>What I found most difficult was … because <br>I think the strength of this submission is … because <br>In order to improve future pieces of academic writing I will attempt to …</p>
                            </div>
                        </div>
                    </form>
                </div>
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