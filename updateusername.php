<?php
    session_start();
    include "connection.php";
    //get user_id
    $userID = $_SESSION["user_id"];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //get new username sent through Ajax
        $newUsername = $_POST["updateUsername"];
        //define errors
        $missingNewUsername = "<p>Please enter your new username!</p>";
        $newUsernameExisted = "<p>Username already existed!</p>";
        $errors = "";
        
        if(!$newUsername)
        {
            $errors .= $missingNewUsername;
        }
        else
        {
            $newUsername = filter_var($newUsername, FILTER_SANITIZE_STRING);
        }

        $sql = "SELECT * FROM users WHERE username='$newUsername'";
        $result = mysqli_query($DB, $sql);
        if(!$result)
        {
            echo "<div class='alert alert-danger'>Unable to execute query. ERROR " . $DB->error . "</div>";
        }
        else
        {
            $numRows = mysqli_num_rows($result);
            if($numRows != 0)
            {
                $errors .= $newUsernameExisted;
            }
        }

        if($errors)
        {
            echo "<div class='alert alert-danger'>$errors</div>";
        }
        else
        {
            //prepare variables for query
            $newUsername = mysqli_real_escape_string($DB, $newUsername);
            //run query to update username
            $sql = "UPDATE users SET username='$newUsername' WHERE user_id='$userID'";
            if(!mysqli_query($DB, $sql))
            {
                echo "<div class='alert alert-danger'>Unable to execute query. ERROR " . $DB->error . "</div>";
            }
            else
            {
                //run query to retrieve new username
                $sql = "SELECT * FROM users WHERE user_id='$userID'";
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
                        echo "<div class='alert alert-danger'>Unable to retrieve username.</div>";
                    }
                    else
                    {
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $_SESSION["username"] = $row["username"];
                    }
                }
            }
        }
    }
?>