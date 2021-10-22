<?php
    session_start();
    include "connection.php";
    //get user_id
    $userID = $_SESSION["user_id"];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $currentPassword = $_POST["currentPassword"];
        $updatePassword = $_POST["updatePassword"];
        $cfUpdatePassword = $_POST["cfUpdatePassword"];
        //define errors
        $missingCurrentPassword = "<p>Please enter your current password!</p>";
        $missingUpdatePassword = "<p>Please enter your new password!</p>";
        $missingCfUpdatePassword = "<p>Please enter your new password confirmation!</p>";
        $wrongCurrentPassword = "<p>Wrong current password!</p>";
        $passwordNotMatch = "<p>Password not match!</p>";
        $invalidPassword = "<p>Your new password must have at least 6 characters, one capital letter, and one number!</p>";
        $errors = "";

        if(!$currentPassword)
        {
            $errors .= $missingCurrentPassword;
        }
        else
        {
            //prepare password for query
            $currentPassword = filter_var($currentPassword, FILTER_SANITIZE_STRING);
            $currentPassword = mysqli_real_escape_string($DB, $currentPassword);
            $currentPassword = hash("sha256", $currentPassword);
            //run query to get user's password
            $sql = "SELECT * FROM users WHERE user_id='$userID' AND password='$currentPassword'";
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
                    $errors .= $wrongCurrentPassword;
                }
            }
        }

        if(!$updatePassword)
        {
            $errors .= $missingUpdatePassword;
        }

        if(!$cfUpdatePassword)
        {
            $errors .= $missingCfUpdatePassword;
        }

        if($updatePassword && $cfUpdatePassword)
        {
            if($updatePassword != $cfUpdatePassword)
            {
                $errors .= $passwordNotMatch;
            }
            else
            {
                if(strlen($updatePassword) < 6 || !preg_match('/[A-Z]/', $updatePassword) || !preg_match('/[0-9]/', $updatePassword))
                {
                    $errors .= $invalidPassword;
                }
            }
        }

        //check if there are errors
        if($errors)
        {
            echo "<div class='alert alert-danger'>$errors</div>";
        }
        else
        {
            //prepare password for query
            $updatePassword = filter_var($updatePassword, FILTER_SANITIZE_STRING);
            $updatePassword = mysqli_real_escape_string($DB, $updatePassword);
            $updatePassword = hash("sha256", $updatePassword);
            //run query to update password
            $sql = "UPDATE users SET password='$updatePassword' WHERE user_id='$userID'";
            if(!mysqli_query($DB, $sql))
            {
                echo "<div class='alert alert-danger'>Unable to execute query. ERROR " . $DB->error . "</div>";
            }
            else
            {
                session_destroy();
            }
        }
    }
?>