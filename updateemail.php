<?php
    session_start();
    include "connection.php";
    //get user_id
    $userID = $_SESSION["user_id"];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $newEmail = $_POST["updateEmail"];
        //define errors
        $missingNewEmail = "<p>Please enter your new email!</p>";
        $emailExisted = "<p>Email already existed!</p>";
        $invalidEmail = "<p>Invalid email address!</p>";
        $errors = "";
        
        if(!$newEmail)
        {
            $errors .= $missingNewEmail;
        }
        else
        {
            $newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL);
            if(!filter_var($newEmail, FILTER_VALIDATE_EMAIL))
            {
                $errors .= $invalidEmail;
            }
            else
            {
                //prepare variables for query
                $newEmail = mysqli_real_escape_string($DB, $newEmail);
                //run query to retrieve email
                $sql = "SELECT * FROM users WHERE email='$newEmail'";
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
                        $errors .= $emailExisted;
                    }
                }
            }
        }

        if($errors)
        {
            echo "<div class='alert alert-danger'>$errors</div>";
        }
        else
        {
            $activationKey = bin2hex(openssl_random_pseudo_bytes(16));
            //run query to update email and activation
            $sql = "UPDATE users SET email='$newEmail', activation='$activationKey' WHERE user_id='$userID'";
            if(!mysqli_query($DB, $sql))
            {
                echo "<div>Unable to execute query. ERROR " . $DB->error . "</div>";
            }
            else
            {
                $message = "Please click on this link to confirm your new email:\r\n";
                $message .= "http://localhost:3000/activate.php?email=" . urlencode($newEmail) . "&key=$activationKey";
                if(!mail($newEmail, "Update email activation", $message, "From: abc@gmail.com"))
                {
                    echo "<div class='alert alert-danger'>Unable to send confirmation email!</div>";
                }
                else
                {
                    echo "<div class='alert alert-success'>Thank you! Please check your email at <strong>$newEmail</strong> to confirm your email update.</div>";
                    session_destroy();
                    setcookie("rememberme", "", time() - 3600);
                }
            }
        }
    }
?>