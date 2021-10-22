<?php
    session_start();
    include "connection.php";
    //define error messages
    $missingEmail = "<p><strong>Please enter your email!</strong></p>";
    $invalidEmail = "<p><strong>Invalid email!</strong></p>";
    $errors = "";
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $email = $_POST["forgotemail"];
        //check user's input
        if(!$email)
        {
            $errors .= $missingEmail;
        }
        else
        {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $errors .= $invalidEmail;
            }
        }

        //if there are any errors
        if($errors)
        {
            //print error message
            echo "<div class='alert alert-danger'>$errors</div>";
        }
        else
        {
            //prepare variable for the query
            $email = mysqli_real_escape_string($DB, $email);
            //run the query to check if email exists in users table
            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($DB, $sql);
            if(!$result)
            {
                echo "<div class='alert alert-danger'>Unable to execute query. ERROR " . $DB->error . "</div>";
            }
            else
            {
                $numRows = mysqli_num_rows($result);
                if($numRows == 0)
                {
                    echo "<div class='alert alert-danger'>Email has not been registered</div>";
                }
                else
                {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    //get the user id
                    $userID = $row["user_id"];
                    $validationKey = bin2hex(openssl_random_pseudo_bytes(16));
                    $time = time();
                    $status = "pending";
                    //insert user details and activation code in the forgotpassword table
                    $sql = "INSERT INTO forgotpassword (user_id, validation_key, time, status) VALUES ('$userID', '$validationKey', '$time', '$status')";
                    if(!mysqli_query($DB, $sql))
                    {
                        echo "<div class='alert alert-danger'>Unable to execute query. Error " . $DB->error . "</div>";
                    }
                    else
                    {
                        $message = "Please click on this link to reset your password\r\n";
                        $message .= "http://localhost:3000/resetpassword.php?user_id=$userID&validation_key=$validationKey";
                        if(mail($email, "Reset Password", $message, "From: abc@gmail.com"))
                        {
                            echo "<div class='alert alert-success'>Thank you. Please check your email at <strong>$email</strong> to reset your password.</div>";
                        }
                        else
                        {
                            echo "<div class='alert alert-danger'>Unable to send reset password email.</div>";
                        }
                    }
                }
            }
        }
    }
?>