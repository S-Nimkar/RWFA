<?php 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $firstname = $secondname = $email = "";
$username_err = $password_err = $confirm_password_err = $firstname_err = $secondname_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter a first name.";
    } else{
        $firstname = trim($_POST["firstname"]);
    }
    
    if(empty(trim($_POST["secondname"]))){
        $secondname_err = "Please enter a second name.";
    } else{
        $secondname = trim($_POST["secondname"]);
    }
    
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        $sql = "SELECT ID FROM User WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT ID FROM System WHERE Username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($secondname_err) && empty($email_err)){
        
        $create_user = "INSERT INTO User (firstName, secondName, email) VALUES (?, ?, ?)";
        if($user_stmt = mysqli_prepare($link, $create_user)){
            mysqli_stmt_bind_param($user_stmt, "sss", $param_firstname, $param_secondname, $param_email);
            $param_firstname = $firstname;
            $param_secondname = $secondname;
            $param_email = $email;

             if(mysqli_stmt_execute($user_stmt)){
                
                mysqli_stmt_close($user_stmt);
                $sql = "SELECT ID FROM User WHERE email = ?";
                if($stmt = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "s", $param_email);
                    // Set parameters
                    $param_email = $email;
                    
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){

                        // Store result
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_bind_result($stmt, $userid);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_close($stmt);
                    }  else {
                        echo "Oops! Something went wrong. Please try again later.!!!";
                    }

                }
            }
        }
        // Prepare an insert statement
        $sql = "INSERT INTO System (UserID, SysGroup, Username, Password) VALUES (?, ?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isss", $param_userid, $param_sysgroup ,$param_username, $param_password);
            
            // Set parameters
            $param_userid = $userid;
            $param_sysgroup = 'User';
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>