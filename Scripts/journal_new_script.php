<?php
    require_once "../Scripts/config.php";
    // Processing form data when form is submitted
    $name = $topic = $goal = "";
    $name_err = $topic_err = $goal_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if name is empty
    if(empty(trim($_POST["journalName"]))){
        $name_err = "Please enter a name.";
    } else{
        $name = trim($_POST["journalName"]);
    }
    
    // Check if topic is empty
    if(empty(trim($_POST["journalTopic"]))){
        $topic_err = "Please enter your topic.";
    } else{
        $topic = trim($_POST["journalTopic"]);
    }

    // Check if goal is empty
    if(empty(trim($_POST["journalGoal"]))){
        $goal_err = "Please enter your goal.";
    } else{
        $goal = trim($_POST["journalGoal"]);
    }
    
    // Validate credentials
    if(empty($name_err) && empty($topic_err) && empty($goal_err)){
        // Prepare a select statement
        $sql = "INSERT INTO Journal (UserID, Name, Topic, Goal, Finished, LastRecord) VALUES (?, ?, ?, ?, '0', CURRENT_TIMESTAMP)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "isss", $param_userid, $param_name, $param_topic, $param_goal);
            $param_userid = $_SESSION["id"];
            $param_name = $name;
            $param_topic = $topic;
            $param_goal = $goal;
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                header("location: index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        } else {
            echo "INVALID SQL";
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>