<?php
    require_once "../Scripts/config.php";
    
    $userid = $_SESSION["id"];
    $sql = "SELECT Journal.Name, Journal.Topic, ReflectiveWritingEntry.Agenda, ReflectiveWritingEntry.Entry, ReflectiveWritingEntry.Record, Journal.ID FROM Journal INNER JOIN ReflectiveWritingEntry ON Journal.ID = ReflectiveWritingEntry.JournalID WHERE Journal.UserID = $userid AND Journal.Finished = 0 ORDER BY ReflectiveWritingEntry.Record DESC" ;
    if ($result = mysqli_query($link, $sql)) {
        $recentEntryInfo = mysqli_fetch_row($result);
        if ($recentEntryInfo) {
            $journalName = $recentEntryInfo[0];
            $journalTopic = $recentEntryInfo[1];
            $RWEAgenda = $recentEntryInfo[2];
            $RWEEntry = $recentEntryInfo[3];
            $RWERecord= $recentEntryInfo[4];
            $journalID = $recentEntryInfo[5];
        }    /* free result set */
        mysqli_free_result($result);
    }
    $sql = "SELECT * FROM Journal INNER JOIN ReflectiveWritingEntry ON Journal.ID = ReflectiveWritingEntry.JournalID WHERE Journal.UserID = $userid AND ReflectiveWritingEntry.Record>=DATE_ADD(CURDATE(),INTERVAL -7 DAY)";
    
    if ($result = mysqli_query($link, $sql)) {
        $DayTotal = mysqli_num_rows($result);
        mysqli_free_result($result);
    }
    
    $sql = "SELECT Goal, Name FROM Journal WHERE UserID = $userid AND Finished = 0 ORDER BY LastRecord DESC LIMIT 3";
    
    if ($result = mysqli_query($link, $sql)) { 
        $recentNameData = [];
        $recentGoalData = [];
        $i = 0;
        while ($row = mysqli_fetch_row($result)) {
            $recentGoalData[$i] = $row[0];
            $recentNameData[$i] = $row[1];
            $i++;
        }
        mysqli_free_result($result);
    }
    
    $sql = "SELECT ID, Topic, Name, Goal, LastRecord FROM Journal WHERE UserID = $userid AND Finished = 0";
    
    if ($result = mysqli_query($link, $sql)) {
        $activeIDData = []; 
        $activeTopicData = [];
        $activeNameData = [];
        $activeGoalData = [];
        $activeLastRecordData = [];
        $i = 0;
        while ($row = mysqli_fetch_row($result)) {
            $activeIDData[$i] = $row[0]; 
            $activeTopicData[$i] = $row[1];
            $activeNameData[$i] = $row[2];
            $activeGoalData[$i] = $row[3];
            $activeLastRecordData[$i] = $row[4];
            $i++;
        }
        mysqli_free_result($result);
    }
    $sql = "SELECT Journal.ID, COUNT(*), MAX(ReflectiveWritingEntry.Record)  FROM Journal INNER JOIN ReflectiveWritingEntry ON Journal.ID = ReflectiveWritingEntry.JournalID WHERE Journal.UserID = $userid AND Finished = 0 GROUP BY Journal.ID";
    
    if ($result = mysqli_query($link, $sql)){
        $activeEntryCount = [];
        $activeLastEntryData = [];
        while ($row = mysqli_fetch_row($result)) {
            $activeEntryCount[$row[0]] = $row[1];
            $activeLastEntryData[$row[0]] = $row[2];
        }
        mysqli_free_result($result);
    }
    
    
    $sql = "SELECT ID, Topic, Name, Goal, LastRecord FROM Journal WHERE UserID = $userid AND Finished = 1";
    
    if ($result = mysqli_query($link, $sql)) {
        $inactiveIDData = []; 
        $inactiveTopicData = [];
        $inactiveNameData = [];
        $inactiveGoalData = [];
        $inactiveLastRecordData = [];
        $i = 0;
        while ($row = mysqli_fetch_row($result)) {
            $inactiveIDData[$i] = $row[0]; 
            $inactiveTopicData[$i] = $row[1];
            $inactiveNameData[$i] = $row[2];
            $inactiveGoalData[$i] = $row[3];
            $inactiveLastRecordData[$i] = $row[4];
            $i++;
        }
        mysqli_free_result($result);
    }
    
    $sql = "SELECT Journal.ID, COUNT(*), MAX(ReflectiveWritingEntry.Record) FROM Journal INNER JOIN ReflectiveWritingEntry ON Journal.ID = ReflectiveWritingEntry.JournalID WHERE Journal.UserID = $userid AND Finished = 1 GROUP BY Journal.ID";
    
    if ($result = mysqli_query($link, $sql)){
        $inactiveEntryCount = [];
        $inactiveLastEntryData = [];
        while ($row = mysqli_fetch_row($result)) {
            $inactiveEntryCount[$row[0]] = $row[1];
            $inactiveLastEntryData[$row[0]] = $row[2];
        }
        mysqli_free_result($result);
    }
    /* close connection */
    mysqli_close($link);

?>