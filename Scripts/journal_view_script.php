<?php
    require_once "../Scripts/config.php";

    $journalid = $_GET["ID"];
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

    $sql = "SELECT ReflectiveWritingEntry.Agenda, ReflectiveWritingEntry.Entry, ReflectiveWritingEntry.Record, ReflectiveWritingEntry.ID FROM Journal INNER JOIN ReflectiveWritingEntry ON Journal.ID = ReflectiveWritingEntry.JournalID WHERE Journal.UserID = $userid AND Journal.ID = $journalid ORDER BY ReflectiveWritingEntry.Record DESC";
    if ($result = mysqli_query($link, $sql)) { 
        $rweAgenda = [];
        $rweEntry = [];
        $rweRecord = [];
        $rweid = [];
        $i = 0;
        while ($row = mysqli_fetch_row($result)) {
            $rweAgenda[$i] = $row[0];
            $rweEntry[$i] = $row[1];
            $rweRecord[$i] = $row[2];
            $rweid = $row[3];
            $i++;
        }
        mysqli_free_result($result);
    }
?>