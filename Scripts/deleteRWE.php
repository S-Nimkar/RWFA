<?php
	session_start();
     
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    require_once "../Scripts/config.php";
	$rweid = $_GET["rweID"];
	$journalid = $_GET["journalID"];
	$userid = $_SESSION['id'];
	//validation step needed
	$sql = "SELECT * FROM Journal INNER JOIN ReflectiveWritingEntry ON Journal.ID = ReflectiveWritingEntry.JournalID INNER JOIN User ON Journal.UserID = User.ID WHERE User.ID = $userid AND Journal.ID = $journalid AND ReflectiveWritingEntry.ID = $rweid";
	if ($result = mysqli_query($link, $sql)) {
        if(mysqli_num_rows($result) == 0){
            header("location: ../Views/forbidden.php");
        } else{
        	$sql = "DELETE FROM ReflectiveWritingEntry WHERE ReflectiveWritingEntry.ID = $rweid";
        	if (mysqli_query($link, $sql)){
        		header("location: ../Views/journal_view.php?ID=$journalid");
        	}
        }
        mysqli_free_result($result);
    }
	



?>