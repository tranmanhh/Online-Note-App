<?php
    //start session
    session_start();
    //connect to the database
    include "connection.php";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //get user input
        $email = $_POST["loginEmail"];
        $password = $_POST["loginPassword"];
        //define error messages
        $missingEmail = "<p><strong>Please enter your email address!</strong></p>";
        $missingPassword = "<p><strong>Please enter your password!</strong></p>";
        $error = "";
        if(!$email)
        {
            $error .= $missingEmail;
        }
        else
        {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        }

        if(!$password)
        {
            $error .= $missingPassword;
        }
        else
        {
            $password = filter_var($password, FILTER_SANITIZE_STRING);
        }

        if($error)
        {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        else
        {
            //if no error
                //prepare variables
            $email = mysqli_real_escape_string($DB, $email);
            $password = mysqli_real_escape_string($DB, $password);
            $password = hash("sha256", $password);

            //run query: check combination of email and password exist
            $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND activation='activated'";
            $result = mysqli_query($DB, $sql);
            //if password does not match: print error
            if(!$result)
            {
                echo "<div class='alert alert-danger'>Cannot execute query. Error: " . $DB->error . "</div>";
            }
            else
            {
                //log the user in: set session variables
                $numRows = mysqli_num_rows($result);
                if($numRows != 1)
                {
                    echo "<div class='alert alert-danger'>Wrong email or password</div>";
                }
                else
                {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $_SESSION["user_id"] = $row["user_id"];
                    $_SESSION["username"] = $row["username"];
                    $_SESSION["email"] = $row["email"];

                    //if 'Remember me' box is unchecked
                    if(empty($_POST["rememberme"]))
                    {
                        echo "success";
                    }
                    else
                    {
                        //create two variables authentificator1 and authentificator2
                        $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
                        $authentificator2 = openssl_random_pseudo_bytes(20);
                        //store them in a cookies for 15 days
                        function f1($key1, $key2)
                        {
                            return $key1 . "," . bin2hex($key2);
                        }
                        $cookieVal = f1($authentificator1, $authentificator2);
                        $expiredTimestamp = time() + 15*24*60*60;
                        setcookie("rememberme", $cookieVal, time() + $expiredTimestamp);
                        //run query to store cookies inside rememberme database
                        function f2($key)
                        {
                            return hash("sha256", $key);
                        }
                        $f2authentificator2 = f2($authentificator2);
                        $userId = $_SESSION["user_id"];
                        $expiredTime = date("Y/m/j, H:i:s", $expiredTimestamp);
                        $sql = "INSERT INTO rememberme (authentificator1, f2authentificator2, user_id, expired_time) VALUES ('$authentificator1', '$f2authentificator2', '$userId', '$expiredTime')";
                        if(!mysqli_query($DB, $sql))
                        {
                            echo "<div class='alert alert-danger'>Unable to execute query. ERROR " . $DB->error . "</div>";
                        }
                        else
                        {
                            echo "success";
                        }
                    }
                }
            }
        }
    }
?>