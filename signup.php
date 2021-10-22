<?php
    //protect users' information while our web server process users' information
    //can purchase ssl-certificate to protect users' information
    //start the session
    session_start();
    //connect to the database
    include "connection.php";

    //define error messages
    $missingUsername = "<p><strong>Please enter a username!</strong></p>";
    $missingEmail = "<p><strong>Please enter an email!</strong></p>";
    $invalidEmail = "<p><strong>You have entered an invalid email!</strong></p>";
    $missingPassword = "<p><strong>Please enter your password!</strong></p>";
    $missingCfPassword = "<p><strong>Please enter your confirmation password!</strong></p>" ;
    $passwordNotMatch = "<p><strong>Confirm password does not match!</strong></p>";
    $invalidPassword = "<p><strong>Your password should be at least 6 characters long, include one capital letter, and one number!</strong></p>";

    $errorMsg = "";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //get user inputs
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $cfPassword = $_POST["cfPassword"];

        if(!$username)
        {
            $errorMsg .= $missingUsername;
        }
        else
        {
            $username = filter_var($username, FILTER_SANITIZE_STRING);
        }

        if(!$email)
        {
            $errorMsg .= $missingEmail;
        }
        else
        {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $errorMsg .= $invalidEmail;
            }
        }

        if(!$password)
        {
            $errorMsg .= $missingPassword;
        }
        if(!$cfPassword)
        {
            $errorMsg .= $missingCfPassword;
        }
        if($password && $cfPassword)
        {
            if($password != $cfPassword)
            {
                $errorMsg .= $passwordNotMatch;
            }
            else
            {
                if(strlen($password) < 6 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password))
                {
                    $errorMsg .= $invalidPassword;
                }
                else
                {
                    $password = filter_var($password, FILTER_SANITIZE_STRING);
                }
            }
        }

        if($errorMsg)
        {
            echo "<div class='alert alert-danger'>$errorMsg</div>";
        }
        else
        {
            //prepare variables for the query
            $username = mysqli_real_escape_string($DB, $username);
            $email = mysqli_real_escape_string($DB, $email);
            $password = mysqli_real_escape_string($DB, $password);
            //$password = md5($password); (32 characters) -> easy to create collison
            $password = hash("sha256", $password); //64 characters
            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = mysqli_query($DB, $sql);
            if(!$result)
            {
                echo "<div class='alert alert-danger'>Unable to execute query! ERROR: " . $DB->error . "</div>";
                exit;
            }
            else
            {
                $numRows = mysqli_num_rows($result);
                if($numRows)
                {
                    echo "<div class='alert alert-danger'>Username already existed!</div>";
                    exit;
                }
            }

            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($DB, $sql);
            if(!$result)
            {
                echo "<div class='alert alert-danger'>Unable to execute query! ERROR: " . $DB->error . "</div>";
                exit;
            }
            else
            {
                $numRows = mysqli_num_rows($result);
                if($numRows)
                {
                    echo "<div class='alert alert-danger'>Email already existed!</div>";
                    exit;
                }
            }

            //create unique activation code and send to user via user's email
            $activationKey = bin2hex(openssl_random_pseudo_bytes(16));
            //Insert user details and activation code in the users table
            $sql = "INSERT INTO users (username, email, password, activation) VALUES ('$username', '$email', '$password', '$activationKey')";
            $result = mysqli_query($DB, $sql);
            if(!$result)
            {
                echo "<div class='alert alert-danger'>Unable to execute query! ERROR: " . $DB->error . "</div>";
                exit;
            }
            else
            {
                $message = "Please click on this link to activate your account:\r\n";
                $message .= "localhost:3000/activate.php?email=" . urlencode($email) . "&key=$activationKey";
                
                if(mail($email, "Confirm your registration", $message, "From: abc@gmail.com"))
                {
                    echo "<div class='alert alert-success'>Thank you. Please check your email at <strong>$email</strong> to confirm your registration.</div>";
                }
                else
                {
                    echo "<div class='alert alert-danger'>Unable to send confirmation email!</div>";
                }
            }
        }
    }
?>