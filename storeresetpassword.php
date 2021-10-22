<?php
    session_start();
    include "connection.php";
    
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $userID = $_POST["userID"];
        $validationKey = $_POST["validationKey"];

        if(!$userID || !$validationKey)
        {
            echo "<div class='alert alert-danger'>There was an error. Please click and reset password on the correct link.</div>";
        }
        else
        {
            //prepare variables for query
            $userID = mysqli_real_escape_string($DB, $userID);
            $validationKey = mysqli_real_escape_string($DB, $validationKey);
            $time = time() - 24*60*60;
            $sql = "SELECT * FROM forgotpassword WHERE user_id='$userID' AND validation_key='$validationKey' AND time > '$time' AND status='pending'";
            $result = mysqli_query($DB, $sql);
            if(!$result)
            {
                echo "<div class='alert alert-danger'>Unable to execute query. ERROR " . $DB->error . "</div>";
            }
            else
            {
                $numRows = mysqli_num_rows($result);
                if($numRows != 1)
                {
                    echo "<div class='alert alert-danger'>Link expired</div>";
                    exit;
                }
            }
        }

        $newPassword = $_POST["newPassword"];
        $cfNewPassword = $_POST["cfNewPassword"];
        //define error
        $missingNewPassword = "<p>Please enter your new password!</p>";
        $missingCfNewPassword = "<p>Please enter your new password confirmation!</p>";
        $passwordNotMatch = "<p><strong>Confirm password does not match!</strong></p>";
        $invalidPassword = "<p><strong>Your password should be at least 6 characters long, include one capital letter, and one number!</strong></p>";
        $errors = "";

        if(!$newPassword)
        {
            $errors .= $missingNewPassword;
        }
        
        if(!$cfNewPassword)
        {
            $errors .= $missingCfNewPassword;
        }

        if($newPassword != $cfNewPassword)
        {
            $errors .= $passwordNotMatch;
        }

        if(strlen($newPassword) < 6 || !preg_match('/[A-Z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword))
        {
            $errors .= $invalidPassword;
        }

        if($errors)
        {
            echo "<div class='alert alert-danger'>$errors</div>";
        }
        else
        {
            //prepare variables for query
            $newPassword = filter_var($newPassword, FILTER_SANITIZE_STRING);
            $newPassword = mysqli_real_escape_string($DB, $newPassword);
            $newPassword = hash("sha256", $newPassword);
            //create query to update user password
            $sql = "UPDATE users SET password='$newPassword' WHERE user_id='$userID'";
            if(!mysqli_query($DB, $sql))
            {
                echo "<div class='alert alert-danger'>Cannot execute query. ERROR " . $DB->error . "</div>";
            }
            else
            {
                //update status of forgotpassword key to used
                $sql = "UPDATE forgotpassword SET status='used' WHERE user_id='$userID' AND validation_key='$validationKey'";
                if(!mysqli_query($DB, $sql))
                {
                    echo "<div class='alert alert-danger'>Cannot execute query. ERROR " . $DB->error . "</div>";
                }
                else
                {
                    echo "<div class='alert alert-success'>Password updated successfully! <a href='index.php'>Login</a></div>";
                }
            }
        }
    }
?>