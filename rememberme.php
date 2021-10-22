<?php
    include "connection.php";
    //if the user is not logged in and rememberme cookie exists
    if(!isset($_SESSION["user_id"]) && !empty($_COOKIE["rememberme"])) //array_key_exists("user_id", $_SESSION)
    {
        //f1: COOKIE: $key1 . "," . bin2hex($key2)
        //f2: hash("sha256", $key2)

        //extract $authentificator 1 and 2 from the cookie
        $authentificators = explode(",", $_COOKIE["rememberme"]);
        $cookieAuthen1 = $authentificators[0];
        $cookieAuthen2 = hex2bin($authentificators[1]);
        $f2cookieAuthen2 = hash("sha256", $cookieAuthen2);
        //look authentificator1 f2authentificator2 in the rememberme table
        $sql = "SELECT * FROM rememberme WHERE authentificator1='$cookieAuthen1'";
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
                echo "<div class='alert alert-danger'>Cannot remember user. Please try again later!</div>";
            }
            else
            {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if(!hash_equals($row["f2authentificator2"], $f2cookieAuthen2))
                {
                    echo "<div class='alert alert-danger'>Cannot remember user. Please try again later!</div>";
                }
                else
                {
                    //generate new authentificators
                    $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
                    $authentificator2 = openssl_random_pseudo_bytes(20);
                    function f1($key1, $key2)
                    {
                        return $key1 . "," . bin2hex($key2);
                    }
                    $cookieVal = f1($authentificator1, $authentificator2);
                    function f2($key2)
                    {
                        return hash("sha256", $key2);
                    }
                    $expiredTime = time() + 15*24*60*60;
                    $f2authentificator2 = f2($authentificator2);
                    $userID = $row["user_id"];
                    //store them in cookie and rememberme table
                    setcookie("rememberme", $cookieVal);
                    $sql = "INSERT INTO rememberme (authentificator1, f2authentificator2, user_id, expired_time) VALUES ('$authentificator1', '$f2authentificator2', '$userID', '$expiredTime')";
                    if(!mysqli_query($DB, $sql))
                    {
                        echo "<div class='alert alert-danger'>Unable to execute query. ERROR " . $DB->error . "</div>";
                    }
                    //Log the user in and redirect them to the note page
                    $_SESSION["user_id"] = $row["user_id"];
                    header("location: mainpageloggedin.php");
                }
            }
        }
    }
?>