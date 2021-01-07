<?php
    require_once "../Scripts/config.php";
    $journalid = $audioid = null;
    $journalid = $_GET["ID"];
    $audioid = $_GET["audioid"];
    $userid = $_SESSION['id'];
    $sql = "SELECT * FROM Journal WHERE ID = $journalid AND UserID = $userid";
    if ($result = mysqli_query($link, $sql)) {
        if(mysqli_num_rows($result) == 0){
            header("location: forbidden.php");
        } else {
            $row = mysqli_fetch_array($result);
            $journalTopic = $row["Topic"];
            $journalName = $row["Name"];
            $journalFinished = $row["Finished"];
            $journalGoal = $row["Goal"];
            $journalLRecord = $row["LastRecord"];
        }
        mysqli_free_result($result);
    }

    $sql = "SELECT ReflectiveWritingEntry.Agenda, ReflectiveWritingEntry.Entry, ReflectiveWritingEntry.Record, ReflectiveWritingEntry.ID, ReflectiveWritingEntry.FeedbackID FROM Journal INNER JOIN ReflectiveWritingEntry ON Journal.ID = ReflectiveWritingEntry.JournalID WHERE Journal.UserID = $userid AND Journal.ID = $journalid ORDER BY ReflectiveWritingEntry.Record DESC";
    if ($result = mysqli_query($link, $sql)) { 
        $rweAgenda = [];
        $rweEntry = [];
        $rweRecord = [];
        $rweid = [];
        $rweFeedbackID = [];
        $i = 0;
        while ($row = mysqli_fetch_row($result)) {
            $rweAgenda[$i] = $row[0];
            $rweEntry[$i] = $row[1];
            $rweRecord[$i] = $row[2];
            $rweid[$i] = $row[3];
            if ($row[4] == null) {
                $rweFeedbackID[$i] = "-1";
            } else {
                $rweFeedbackID[$i] = $row[4];
            }
            $i++;
        }
        mysqli_free_result($result);
    }
    $WCCommentPos =  array("A star is born!", "A stroke of genius", "Well done on uploading the reflection." , "Congratulations on uploading the reflection.", "Thanks for uploading the reflection.");
    $WCCommentNeg =  array("Aim to write more next time.", "Give a little more", "Go chew the cud", "Can you say a bit more about that?", "Expand your thoughts", "Widen your horizons", "Check Skills Hub to see what else you could write in your reflections", "Check Skills Hub for further ideas to write in your reflections");
?>