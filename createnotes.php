<?php
    session_start();
    include "connection.php";
    //get user_id
    $userID = $_SESSION["user_id"];
    //get the current time
    $time = time();
    //run a query to create new note
    $sql = "INSERT INTO notes (user_id, note, time) VALUES ('$userID', '', '$time')";
    if(!mysqli_query($DB, $sql))
    {
        echo "error";
    }
    else
    {
        //returns the auto generated id used in the last query
        echo mysqli_insert_id($DB);
    }
?>