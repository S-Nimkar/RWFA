<?php
	session_start();
     
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }

    require_once "../Scripts/config.php";
	$journalid = $_GET["journalID"];
	$userid = $_SESSION['id'];
	

	$sql = "SELECT Journal.Name, Journal.Topic, Journal.Goal FROM Journal INNER JOIN User ON Journal.UserID = User.ID WHERE User.ID = $userid AND Journal.ID = $journalid";
	if ($result = mysqli_query($link, $sql)) {
        if(mysqli_num_rows($result) == 0){
            header("location: ../Views/forbidden.php");
        } else{
            $row = mysqli_fetch_array($result);
            $journalTopic = $row["Topic"];
            $journalName = $row["Name"];
            $journalGoal = $row["Goal"];
            mysqli_free_result($result);
            $sql = "SELECT ReflectiveWritingEntry.Agenda, ReflectiveWritingEntry.Entry, ReflectiveWritingEntry.Record, ReflectiveWritingEntry.ID FROM Journal INNER JOIN ReflectiveWritingEntry ON Journal.ID = ReflectiveWritingEntry.JournalID WHERE Journal.UserID = $userid AND Journal.ID = $journalid ORDER BY ReflectiveWritingEntry.Record DESC";
            if ($result = mysqli_query($link, $sql)) { 
                $rweAgenda = [];
                $rweEntry = [];
                $rweRecord = [];
                $i = 0;
                while ($row = mysqli_fetch_row($result)) {
                    $rweAgenda[$i] = $row[0];
                    $rweEntry[$i] = $row[1];
                    $rweRecord[$i] = $row[2];
                    $i++;
                }
                mysqli_free_result($result);
            }
        	   
        }
        mysqli_free_result($result);
    }
	$path = "journal".$journalid . ".txt";
    $myfile = fopen($path, "w") or die("Unable to open file!");
    $text = $journalName . "\n" . $journalTopic . "\n" . $journalGoal. "\n";
    fwrite($myfile, $text);
    $min = count($rweAgenda);
    for($i = 0; $i < $min; $i++) {
        $text = "\n" . $rweAgenda[$i] . "\n" . $rweEntry[$i] . "\n" . $rweRecord[$i] . "\n";
    }
    fwrite($myfile, $text);
    fclose($myfile);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($path).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($path));
    flush(); // Flush system output buffer
    readfile($path);
    unlink($path);

    header("location: ../Views/journal_view.php?ID=$journalid");


?>