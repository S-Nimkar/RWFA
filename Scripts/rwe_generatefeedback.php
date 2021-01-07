<?php
    // Initialize the session
    session_start();
     
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    $journalid = $_GET["journalID"];
    $rweid = $_GET["rweID"];
    require_once "../Scripts/config.php";
    // Processing form data when form is submitted
    $userid = $_SESSION['id'];

    $sql = "SELECT * FROM Journal WHERE ID = $journalid AND UserID = $userid";
    if ($result = mysqli_query($link, $sql)) {
        if(mysqli_num_rows($result) == 0){
            header("location: forbidden.php");
        }
        mysqli_free_result($result);
    }

    $sql = "SELECT ReflectiveWritingEntry.Entry FROM Journal INNER JOIN ReflectiveWritingEntry ON Journal.ID = ReflectiveWritingEntry.JournalID WHERE Journal.UserID = $userid AND Journal.ID = $journalid AND ReflectiveWritingEntry.ID = $rweid ORDER BY ReflectiveWritingEntry.Record DESC";

    if ($result = mysqli_query($link, $sql)) { 
        while ($row = mysqli_fetch_row($result)) {
            $rweEntry = $row[0];
        }
        mysqli_free_result($result);
    }

    $wordcount = "";
    $positive_comments = [];
    $negative_comments = [];

    $sanitsed_entry = strtolower(preg_replace('/[^\w]+/', '_', $rweEntry));
    $wordcount = count(preg_split("/[_]+/", $sanitsed_entry));

    $pos_comment_emotion = "You have included how you feel about the reflection.";
    $pos_comment_approach = "You have dicussed how you can view the problem differently next time.";
    $pos_comment_interpret = "You have shown how you reflected and interpreted your past actions";
    $pos_comment_learn = "You have discussed what you were able to succefully learn in the reflection" ;
    $pos_comment_difficult = "You were able to identify a particularly challenging area during this reflection";
    $pos_comment_future ="You have established how intend to explore the problem in the future";
    $pos_comment_positive = "You were able to find a positive aspect of the problem during the reflection";
    $pos_comment_example = "You supplied examples to back up your reflection";
    $pos_comment_reasioning = "You gave reasoning behind your reflection";

    $neg_comment_emotion = "Make sure to include how you felt about the experience.";
    $neg_comment_approach = "Remember to suggest how you could have done things differently.";
    $neg_comment_interpret = "Could you interpret any of your reflection in a new way?";
    $neg_comment_learn = "Were you able to successfully learn anything - What is that?";
    $neg_comment_difficult = "The problem areas could be explored in more detail in the future";
    $neg_comment_future ="What do you intend to do in the future?";
    $neg_comment_positive = "Have you identified anything positive about your experience? What went well?";
    $neg_comment_example = "Try to include some more examples next time!";
    $neg_comment_reasioning = "Make sure your reasoning behing the reflection is clear";

    $emotion_regex = '/i(_(feel|felt|was|is|wasn_t|m|)?)(_(really|very))_(happy|sad|upset|angry|furious|over_the_moon|disappointed|proud|worried|concerned|hurt|wounded|depressed|anxious|pleased|delighted|gained_a_new_respect)/';
    $approach_regex = '/((instead_of|alternatively|on_the_other_hand|perhaps|maybe)|i_(could|should|ought_to)(_have)?(_instead)?)/';
    $interpret_regex = '/i_(realised?|thought|knew|understood|didnt_think_that|reconsidered)(_that)?(_how)?/';
    $learn_regex = '/(this)?(_has)?_(help(ed)?|made_me_realise|understand|provided|given(_me)?(_an)?(_insight)?)/';
    $difficult_regex = '/((_?unfortunately|_?however|but))+_(this_means_that|this_suggests|it_might_be_that|it_seems|it_appears"|it_means|i)/';
    $future_regex = '/(in(_the)?_future|next_time|another_time|on_another_occasion)_(i_(would)?_(like|need_to)|(i_ll|i_will|i_wont|i_might|i_can_t|i))/';
    $positive_regex = '/(i_am|i|my(_good)?|it_s)_(success|succeeded_in|pleased(_about)?|did_well|done_well|made_a(_good)?_job(_of)?|did_a_good_job|happy_with|pleased(_that|_with)?|great|wicked|cool|fantastic|wonderful|(really)?(_happy|_great|_amazing|_terrific|_wonderful|_incredible))/';
    $example_regex = '/(for_example|for_instance|e_g|i_e|such_as|experiences?)/';
    $reasioning_regex = '/(because|since|the_reasons?|why)/';

    preg_match($emotion_regex, $sanitsed_entry, $match);
    if (count($match)) {
        array_push($positive_comments, $pos_comment_emotion);
    } else {
        array_push($negative_comments, $neg_comment_emotion);
    }

    preg_match($approach_regex, $sanitsed_entry, $match);
    if (count($match)) {
        array_push($positive_comments, $pos_comment_approach);
    } else {
        array_push($negative_comments, $neg_comment_approach);
    }

    preg_match($interpret_regex, $sanitsed_entry, $match);
    if (count($match)) {
        array_push($positive_comments, $pos_comment_interpret);
    } else {
        array_push($negative_comments, $neg_comment_interpret);
    }

    preg_match($learn_regex, $sanitsed_entry, $match);
    if (count($match)) {
        array_push($positive_comments, $pos_comment_learn);
    } else {
        array_push($negative_comments, $neg_comment_learn);
    }

    preg_match($difficult_regex, $sanitsed_entry, $match);
    if (count($match)) {
        array_push($positive_comments, $pos_comment_difficult);
    } else {
        array_push($negative_comments, $neg_comment_difficult);
    }

    preg_match($future_regex, $sanitsed_entry, $match);
    if (count($match)) {
        array_push($positive_comments, $pos_comment_future);
    } else {
        array_push($negative_comments, $neg_comment_future);
    }

    preg_match($positive_regex, $sanitsed_entry, $match);
    if (count($match)) {
        array_push($positive_comments, $pos_comment_positive);
    } else {
        array_push($negative_comments, $neg_comment_positive);
    }

    preg_match($example_regex, $sanitsed_entry, $match);
    if (count($match)) {
        array_push($positive_comments, $pos_comment_example);
    } else {
        array_push($negative_comments, $neg_comment_example);
    }

    preg_match($reasioning_regex, $sanitsed_entry, $match);
    if (count($match)) {
        array_push($positive_comments, $pos_comment_reasioning);
    } else {
        array_push($negative_comments, $neg_comment_reasioning);
    }

    $unformatted_json = array('word_count' => $wordcount, 'positive_comments' => $positive_comments, 'negative_comments' => $negative_comments);    
    $formatted_pos = implode("|", $positive_comments);
    $formatted_neg = implode("|", $negative_comments);

    $sql = "INSERT INTO RWEFeedback (WordCount, Positive, Negative) VALUES ('$wordcount', '$formatted_pos', '$formatted_neg')";
    echo "$sql";
    if ($result = mysqli_query($link, $sql)) { 
        $sql = "SELECT LAST_INSERT_ID()";
        if ($result = mysqli_query($link, $sql)) { 
            while ($row = mysqli_fetch_row($result)) {
                $rwefID = $row[0];
            }
        }
        mysqli_free_result($result);
    } else {
        echo"Could not get feedback Entry.</br>";
    }

    $sql = "UPDATE ReflectiveWritingEntry SET FeedbackID = $rwefID WHERE ID = $rweid";
    if (mysqli_query($link, $sql)){
        if ($wordcount > 50) {
            $sql = "SELECT COUNT(ReflectiveWritingEntry.ID) FROM ReflectiveWritingEntry INNER JOIN Journal ON Journal.ID = ReflectiveWritingEntry.JournalID WHERE Length(Entry) > 50 AND Journal.UserID = $userid";
            $audioVal = mysqli_fetch_row(mysqli_query($link, $sql))[0];
        } else {
            $sql = "SELECT COUNT(ReflectiveWritingEntry.ID) FROM ReflectiveWritingEntry INNER JOIN Journal ON Journal.ID = ReflectiveWritingEntry.JournalID WHERE Length(Entry) <= 50 AND Journal.UserID = $userid";
            $audioVal = mysqli_fetch_row(mysqli_query($link, $sql))[0] + 200;
        }

        header("location: ../Views/journal_view.php?ID=$journalid&audioid=$audioVal#$rweid");
    } else {
        echo "internal server error";
    }
    mysqli_close($link);
?>

