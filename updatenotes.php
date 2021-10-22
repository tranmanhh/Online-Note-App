<?php
    session_start();
    include "connection.php";
    //get id of the note sent through Ajax call
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //get id of the note sent through Ajax call
        $noteID = $_POST["id"];
        //get the content of the notes
        $note = $_POST["note"];
        //get the time
        $time = time();
        //run a query to update the note
        $sql = "UPDATE notes SET note='$note', time = '$time' WHERE id='$noteID'";
        if(!mysqli_query($DB, $sql))
        {
            echo "error";
        }
    }
?>