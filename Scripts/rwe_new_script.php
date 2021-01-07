<?php
// Processing form data when form is submitted
    $userid = $_SESSION['id'];

    $sql = "SELECT * FROM Journal WHERE ID = $journalid AND UserID = $userid";
    if ($result = mysqli_query($link, $sql)) {
        if(mysqli_num_rows($result) == 0){
            header("location: forbidden.php");
        }
        mysqli_free_result($result);
    }
    $agenda = $entry = "";
    $agenda_err = $entry_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if name is empty
    if(empty(trim($_POST["agenda"]))){
        $agenda_err = "Please choose an agenda.";
    } else{
        $agenda = trim($_POST["agenda"]);
    }
    // Check if topic is empty
    if(empty(trim($_POST["entry"]))){
        $entry_err = "Entry is blank.";
    } else{
        $entry = trim($_POST["entry"]);
    }
    $journalid = $_POST["journalid"];
    // Validate credentials
    if(empty($entry_err) && empty($agenda_err)){
        // Prepare a select statement
        $sql = "INSERT INTO ReflectiveWritingEntry (JournalID, Agenda, Entry, Record) VALUES (?, ?, ?, CURRENT_TIMESTAMP)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "iss", $param_journalid, $param_agenda, $param_entry);
            $param_journalid = $journalid;
            $param_agenda = $agenda;
            $param_entry = $entry;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                header("location: journal_view.php?ID=$journalid");
            } else{
                echo "Something went very wrong. Please try again later.";
            }
        } else {
            echo "INVALID SQL";
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>